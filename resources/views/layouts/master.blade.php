<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VOVOI - Beyond Ordinary')</title>
    <meta name="description" content="Explore our curated collection of premium electronics, synced in real-time across all locations.">
    <link rel="stylesheet" href="{{ asset('css/vovoi.css') }}">
    @yield('extra_css')
</head>
<body>

    <x-navbar />

    <main style="flex: 1;">
        @yield('konten_utama')
    </main>

    <x-footer />

    @yield('extra_js')
</body>
</html>
