@extends('layouts.master')

@section('konten_utama')
<div style="text-align: center; background-color: white; padding: 50px; border-radius: 8px; border: 1px solid #ccc; width: 50%; margin: 0 auto;">
    <h1 style="font-size: 60px; margin: 0;">🎉</h1>
    <h2 style="color: #28A745; margin-top: 10px;">Transaksi Berhasil!</h2>
    <p style="color: #666;">Terima kasih, pesanan Anda sedang kami proses.</p>
    <p>Nomor Resi: <strong style="color: #333;">INV-2026-XYZ99</strong></p>

    <br>
    <a href="/" style="display: inline-block; background-color: #0B5ED7; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 15px;">
        Kembali ke Beranda
    </a>
</div>
@endsection
