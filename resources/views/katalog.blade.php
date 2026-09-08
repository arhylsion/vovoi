@extends('layouts.master')

@section('konten_utama')
<h2 style="color: #333; margin-bottom: 20px;">Katalog Produk</h2>

<div style="background-color: white; border: 1px solid #ccc; width: 250px; padding: 15px; border-radius: 8px;">
    <div style="background-color: #eee; height: 150px; text-align: center; line-height: 150px; border-radius: 4px; overflow: hidden;">
        <img src="{{ asset('assets/images/sepatu.svg') }}" alt="Foto Produk" style="width: 100%; height: 100%; object-fit: contain; border-radius: 4px;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        <span style="display: none; line-height: 150px;">[Foto Produk]</span>
    </div>
    <h3 style="margin-top: 15px;">Nama Sepatu/Baju</h3>
    <p style="color: #E63946; font-weight: bold; font-size: 18px;">Rp 150.000</p>

    <a href="/detail" style="display: block; text-align: center; background-color: #0B5ED7; color: white; padding: 10px; text-decoration: none; border-radius: 5px; font-weight: bold;">
        Lihat Detail
    </a>
</div>
@endsection
