<?php

require __DIR__ . '/../vendor/autoload.php';

function getWikimediaImages($query, $count = 4) {
    $client = new \GuzzleHttp\Client([
        'headers' => [
            'User-Agent' => 'TravelAppBot/1.0 (contact@example.com) GuzzleHttp/7'
        ],
        'verify' => false
    ]);

    // Query Wikimedia Commons API for search results
    // We request pageimages (thumbnail) with size 800px
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
                $urls[] = $page['thumbnail']['source'];
            }
        }
        
        return array_slice(array_unique($urls), 0, $count);
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        return [];
    }
}

$images = getWikimediaImages("Kawah Ijen Banyuwangi");
print_r($images);
