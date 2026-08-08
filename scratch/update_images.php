<?php

use App\Models\Destination;
use Illuminate\Support\Str;

function cleanSearchQuery($name) {
    $query = $name;
    
    // Remove common prefixes
    $prefixes = [
        '/^paket liburan/i',
        '/^paket tour/i',
        '/^paket/i',
        '/^open trip/i',
        '/^jelajah alam/i',
        '/^liburan seru/i',
        '/^private tour guide/i',
        '/^private guide/i',
        '/^pemandu wisata/i',
        '/^local tour guide/i',
        '/^local guide/i',
        '/^guide trekking/i',
        '/^guide wisat/i',
        '/^guide/i',
        '/^pemandu/i'
    ];
    
    foreach ($prefixes as $pattern) {
        $query = preg_replace($pattern, '', $query);
    }
    
    // Remove common suffixes
    $suffixes = [
        '/\s+\d+d\d+n\b/i', // e.g. 3d2n, 4d3n
        '/\s+\d+ hari\b/i',
        '/\s+midnight\b/i',
        '/\s+sunrise midnight\b/i',
        '/\s+liveaboard\b/i',
        '/\s+\(english speaking\)/i',
        '/\s+\(lokal\)/i',
        '/\s+\(spesialis malam\)/i',
        '/\s+\(bahasa prancis\)/i',
        '/\s+\(japanese speaking\)/i',
        '/\s+\(ranger resmi\)/i',
        '/\s+\(ranger\)/i',
        '/\s+berlisensi\b/i',
        '/\s+ranger\b/i',
        '/\s+lpi\b/i',
        '/\s+hpi\b/i'
    ];
    
    foreach ($suffixes as $pattern) {
        $query = preg_replace($pattern, '', $query);
    }
    
    $query = trim($query);
    return empty($query) ? $name : $query;
}

function getWikimediaImagesForQuery($query, $count = 4) {
    $client = new \GuzzleHttp\Client([
        'headers' => [
            'User-Agent' => 'TravelAppSearchBot/1.0 (contact@example.com) GuzzleHttp/7'
        ],
        'verify' => false,
        'timeout' => 5 // 5 seconds timeout
    ]);

    $url = "https://commons.wikimedia.org/w/api.php?action=query&format=json&generator=search&gsrsearch=" . urlencode($query) . "&gsrlimit=" . ($count * 2) . "&prop=pageimages&piprop=thumbnail&pithumbsize=800";
    
    try {
        $response = $client->request('GET', $url);
        $data = json_decode($response->getBody()->getContents(), true);
        
        if (empty($data['query']['pages'])) {
            return [];
        }
        
        $urls = [];
        foreach ($data['query']['pages'] as $page) {
            if (!empty($page['thumbnail']['source'])) {
                // Ignore small icons or non-landscape maps if any
                $source = $page['thumbnail']['source'];
                if (str_contains($source, 'Red_Pencil_Icon') || str_contains($source, 'Locator_map')) {
                    continue;
                }
                $urls[] = $source;
            }
        }
        
        return array_slice(array_unique($urls), 0, $count);
    } catch (\Exception $e) {
        // Fallback silently on network errors
        return [];
    }
}

// Predefined high-quality Unsplash fallbacks grouped by type
$fallbacks = [
    'tiket' => [
        'photo-1544829099-b9a0c07fad1a', 'photo-1508009603885-50cf7c579365', 'photo-1598977123418-45f04b01d1bb',
        'photo-1568849676085-51415703900f', 'photo-1584551246679-0daf3d275d0f', 'photo-1534447677768-be436bb09401',
        'photo-1564507592333-c60657eea523', 'photo-1528127269322-539801943592', 'photo-1518638150341-db4e437c3574',
        'photo-1566737236500-c8ac43014a67'
    ],
    'paket' => [
        'photo-1507525428034-b723cf961d3e', 'photo-1469854523086-cc02fe5d8800', 'photo-1476514525535-07fb3b4ae5f1',
        'photo-1506929562872-bb421503ef21', 'photo-1530789253388-582c481c54b0', 'photo-1488646953014-85cb44e25828',
        'photo-1501785888041-af3ef285b470', 'photo-1475924156734-496f6cac6ec1', 'photo-1527631746610-bca00a040d60',
        'photo-1516483638261-f4dbaf036963'
    ],
    'tourguide' => [
        'photo-1527529482837-4698179dc6ce', 'photo-1551882547-ff40c63fe5fa', 'photo-1488085061387-422e29b40080',
        'photo-1501555088652-021faa106b9b', 'photo-1522202176988-66273c2fd55f', 'photo-1519671482749-fd09be7ccebf',
        'photo-1517841905240-472988babdf9', 'photo-1539571696357-5a69c17a67c6', 'photo-1506794778202-cad84cf45f1d',
        'photo-1494790108377-be9c29b29330'
    ]
];

$excludedNames = [
    'Candi Borobudur', 
    'Dufan Ancol', 
    'Candi Prambanan', 
    'Taman Mini Indonesia Indah (TMII)', 
    'Kebun Raya Bogor'
];

$destinations = Destination::all();
$updatedCount = 0;

echo "Starting image updater for " . $destinations->count() . " destinations...\n";

foreach ($destinations as $dest) {
    if (in_array($dest->name, $excludedNames)) {
        echo "Skipping excluded: {$dest->name}\n";
        continue;
    }
    
    $cleanQuery = cleanSearchQuery($dest->name);
    echo "Searching for '{$cleanQuery}' (original: '{$dest->name}')...\n";
    
    $images = getWikimediaImagesForQuery($cleanQuery, 4);
    
    $mainImage = null;
    $gallery = [];
    
    if (count($images) >= 4) {
        $mainImage = $images[0];
        $gallery = array_slice($images, 1, 3);
        echo "  Found in Wikimedia: 1 main image, 3 gallery images.\n";
    } else {
        // Fallback to Unsplash
        echo "  Not enough Wikimedia images (" . count($images) . "). Falling back to Unsplash.\n";
        $type = in_array($dest->type, ['tiket', 'paket', 'tourguide']) ? $dest->type : 'paket';
        $ids = $fallbacks[$type];
        
        // Take a dynamic set of Unsplash IDs based on destination id
        $offset = $dest->id % count($ids);
        $unsplashId = $ids[$offset];
        $mainImage = "https://images.unsplash.com/{$unsplashId}?auto=format&fit=crop&w=800&q=80";
        
        // Get 3 other unique IDs for gallery
        $otherIds = array_values(array_diff($ids, [$unsplashId]));
        shuffle($otherIds);
        for ($g = 0; $g < 3; $g++) {
            $gallery[] = "https://images.unsplash.com/{$otherIds[$g]}?auto=format&fit=crop&w=800&q=80";
        }
    }
    
    // Save to destination
    $dest->image = $mainImage;
    $dest->gallery = $gallery;
    $dest->save();
    
    $updatedCount++;
}

echo "\nCompleted. Successfully updated {$updatedCount} destinations with matching images!\n";
