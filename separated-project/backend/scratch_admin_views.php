<?php

$files = [
    'resources/views/layouts/admin.blade.php' => <<<'EOT'
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col transition-all duration-300">
            <div class="h-16 flex items-center justify-center border-b border-gray-800">
                <span class="text-xl font-bold uppercase tracking-wider">Travel Admin</span>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-blue-400' : 'text-gray-300' }}">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-blue-400' : 'text-gray-300' }}">
                    <i class="fas fa-map-marked-alt w-5 text-center"></i>
                    <span>Destinasi / Produk</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 text-blue-400' : 'text-gray-300' }}">
                    <i class="fas fa-shopping-cart w-5 text-center"></i>
                    <span>Pesanan</span>
                </a>
                
                <div class="pt-6 mt-6 border-t border-gray-800">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-400 hover:text-white transition">
                        <i class="fas fa-globe w-5 text-center"></i>
                        <span>Lihat Website</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10">
                <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-600">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium">Logout</button>
                    </form>
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
EOT,
    'resources/views/admin/dashboard.blade.php' => <<<'EOT'
@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-500 text-sm font-medium">Total Produk Wisata</h3>
            <span class="bg-blue-100 text-blue-600 p-2 rounded-lg"><i class="fas fa-map text-lg"></i></span>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-500 text-sm font-medium">Total Pesanan</h3>
            <span class="bg-purple-100 text-purple-600 p-2 rounded-lg"><i class="fas fa-shopping-bag text-lg"></i></span>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-500 text-sm font-medium">Pesanan Menunggu</h3>
            <span class="bg-yellow-100 text-yellow-600 p-2 rounded-lg"><i class="fas fa-clock text-lg"></i></span>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $pendingOrders }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-gray-500 text-sm font-medium">Pendapatan (Terkonfirmasi)</h3>
            <span class="bg-green-100 text-green-600 p-2 rounded-lg"><i class="fas fa-wallet text-lg"></i></span>
        </div>
        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Selamat Datang di Admin Panel</h2>
    <p class="text-gray-600">Gunakan menu di samping untuk mengelola data website Anda. Anda bisa menambah paket wisata baru, menghapusnya, serta melihat laporan pemesanan dari pelanggan.</p>
</div>
@endsection
EOT,
    'resources/views/admin/products/index.blade.php' => <<<'EOT'
@extends('layouts.admin')
@section('title', 'Manajemen Produk / Destinasi')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="font-semibold text-gray-800">Daftar Destinasi Wisata</h2>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Produk Baru
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm border-b">
                    <th class="px-6 py-3 font-medium">ID</th>
                    <th class="px-6 py-3 font-medium">Gambar</th>
                    <th class="px-6 py-3 font-medium">Nama Destinasi</th>
                    <th class="px-6 py-3 font-medium">Harga</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-500">#{{ $product->id }}</td>
                    <td class="px-6 py-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-12 object-cover rounded-md shadow-sm">
                        @else
                            <div class="w-16 h-12 bg-gray-200 rounded-md flex items-center justify-center text-gray-400 text-xs">No img</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-800 p-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 p-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada produk wisata.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
EOT,
    'resources/views/admin/products/create.blade.php' => <<<'EOT'
@extends('layouts.admin')
@section('title', 'Tambah Destinasi Baru')
@section('content')
<div class="max-w-3xl bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Destinasi</label>
            <input type="text" name="name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
            <input type="number" name="price" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="4" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition"></textarea>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
            <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">Simpan</button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-medium transition">Batal</a>
        </div>
    </form>
</div>
@endsection
EOT,
    'resources/views/admin/products/edit.blade.php' => <<<'EOT'
@extends('layouts.admin')
@section('title', 'Edit Destinasi')
@section('content')
<div class="max-w-3xl bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Destinasi</label>
            <input type="text" name="name" value="{{ $product->name }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
            <input type="number" name="price" value="{{ $product->price }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="4" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">{{ $product->description }}</textarea>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar (Kosongkan jika tidak ingin mengubah)</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-24 object-cover rounded shadow">
                </div>
            @endif
            <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">Update</button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-medium transition">Batal</a>
        </div>
    </form>
</div>
@endsection
EOT,
    'resources/views/admin/orders/index.blade.php' => <<<'EOT'
@extends('layouts.admin')
@section('title', 'Manajemen Pesanan')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-semibold text-gray-800">Daftar Pesanan / Booking Masuk</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm border-b">
                    <th class="px-6 py-3 font-medium">ID Order</th>
                    <th class="px-6 py-3 font-medium">Pelanggan</th>
                    <th class="px-6 py-3 font-medium">Destinasi</th>
                    <th class="px-6 py-3 font-medium">Tgl Booking</th>
                    <th class="px-6 py-3 font-medium">Pax</th>
                    <th class="px-6 py-3 font-medium">Total Harga</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-500">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ $order->nama }}</div>
                        <div class="text-xs text-gray-500">{{ $order->no_hp }}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-800">{{ $order->destination->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($order->tanggal_booking)->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $order->jumlah_orang }} org</td>
                    <td class="px-6 py-4 text-gray-800 font-medium">
                        Rp {{ number_format(($order->destination->price ?? 0) * $order->jumlah_orang, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($order->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full font-medium">Menunggu</span>
                        @elseif($order->status == 'confirmed')
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">Terkonfirmasi</span>
                        @else
                            <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full font-medium">{{ ucfirst($order->status) }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($order->status == 'pending')
                        <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pesanan ini?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded text-xs font-medium transition">
                                Konfirmasi
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada pesanan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
EOT
];

foreach ($files as $path => $content) {
    $fullPath = __DIR__ . '/' . $path;
    if (!is_dir(dirname($fullPath))) {
        mkdir(dirname($fullPath), 0777, true);
    }
    file_put_contents($fullPath, $content);
}

echo "Files created successfully.";
