@extends('layouts.admin')

@section('konten_admin')
    <!-- 1. NOTIFIKASI BERHASIL TAMBAH PRODUK -->
    @if(session('success'))
        <div style="background-color: #ecfdf5; color: #065f46; padding: 14px 18px; border-radius: 10px; border: 1px solid #a7f3d0; margin-bottom: 24px; font-size: 14px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <!-- 2. HEADER HALAMAN & TOMBOL TAMBAH PRODUK -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="margin: 0; font-size: 22px; font-weight: 700; color: #0f172a;">Daftar Produk Toko</h2>
            <p style="margin: 4px 0 0 0; font-size: 14px; color: #64748b;">
                Kelola seluruh barang dagangan yang tampil di halaman depan toko Anda ({{ $products->count() }} Produk Aktif).
            </p>
        </div>
        <a href="/admin/products/create" style="background-color: #0B5ED7; color: #ffffff; text-decoration: none; padding: 11px 20px; border-radius: 8px; font-size: 14px; font-weight: 600;">
            + Tambah Produk Baru
        </a>
    </div>

    <!-- 3. TABEL KATALOG PRODUK SELLER CENTER -->
    <div style="background-color: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="background-color: #f8fafc; color: #475569; text-align: left; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 14px 20px; font-weight: 600; width: 90px;">Foto</th>
                    <th style="padding: 14px 20px; font-weight: 600;">Info Produk</th>
                    <th style="padding: 14px 20px; font-weight: 600;">Harga Satuan</th>
                    <th style="padding: 14px 20px; font-weight: 600;">Tanggal Ditambahkan</th>
                    <th style="padding: 14px 20px; font-weight: 600; text-align: right;">Pratinjau</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <!-- Kolom 1: Thumbnail Foto Produk -->
                        <td style="padding: 16px 20px; vertical-align: middle;">
                            @if($product->image)
                                <img src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}" style="width: 64px; height: 64px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; display: block;">
                            @else
                                <div style="width: 64px; height: 64px; background-color: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 11px; color: #94a3b8; text-align: center;">
                                    No Img
                                </div>
                            @endif
                        </td>

                        <!-- Kolom 2: Nama & Cuplikan Spesifikasi -->
                        <td style="padding: 16px 20px; vertical-align: middle;">
                            <div style="font-weight: 700; color: #0f172a; font-size: 15px; margin-bottom: 4px;">
                                {{ $product->name }}
                            </div>
                            <div style="font-size: 13px; color: #64748b; max-width: 420px; line-height: 1.5;">
                                {{ \Illuminate\Support\Str::limit($product->description, 90) }}
                            </div>
                        </td>

                        <!-- Kolom 3: Harga Produk -->
                        <td style="padding: 16px 20px; vertical-align: middle; font-weight: 700; color: #0f172a; font-size: 15px;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <!-- Kolom 4: Waktu Input -->
                        <td style="padding: 16px 20px; vertical-align: middle; color: #64748b; font-size: 13px;">
                            {{ $product->created_at ? $product->created_at->format('d M Y, H:i') : '-' }}
                        </td>

                        <!-- Kolom 5: Tautan Cek Halaman Detail -->
                        <td style="padding: 16px 20px; vertical-align: middle; text-align: right;">
                            <a href="/detail/{{ $product->id }}" target="_blank" style="color: #0B5ED7; text-decoration: none; font-weight: 600; font-size: 13px; background-color: #eff6ff; padding: 7px 12px; border-radius: 6px; border: 1px solid #bfdbfe;">
                                Lihat di Toko &nearr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 48px 20px; color: #64748b;">
                            Belum ada produk di etalase. Klik tombol <strong>+ Tambah Produk Baru</strong> untuk mulai mengunggah barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

