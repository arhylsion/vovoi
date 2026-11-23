@extends('layouts.admin')

@section('konten_admin')
    <!-- 1. NOTIFIKASI BERHASIL TAMBAH/EDIT/HAPUS PRODUK -->
    @if(session('success'))
        <div style="background-color: #ecfdf5; color: #065f46; padding: 14px 18px; border-radius: 10px; border: 1px solid #a7f3d0; margin-bottom: 24px; font-size: 14px; font-weight: 600;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- 2. HEADER HALAMAN & TOMBOL TAMBAH PRODUK -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="margin: 0; font-size: 22px; font-weight: 700; color: #0f172a;">Daftar Produk Toko</h2>
            <p style="margin: 4px 0 0 0; font-size: 14px; color: #64748b;">
                Kelola seluruh barang dagangan yang tampil di halaman depan toko Anda ({{ $products->count() }} Produk Aktif).
            </p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('admin.categories.index') }}" style="background-color: #ffffff; color: #0f172a; border: 1px solid #cbd5e1; text-decoration: none; padding: 10px 18px; border-radius: 8px; font-size: 14px; font-weight: 600;">
                Kelola Kategori
            </a>
            <a href="/admin/products/create" style="background-color: #0B5ED7; color: #ffffff; text-decoration: none; padding: 11px 20px; border-radius: 8px; font-size: 14px; font-weight: 600;">
                + Tambah Produk Baru
            </a>
        </div>
    </div>

    <!-- 3. TABEL KATALOG PRODUK SELLER CENTER -->
    <div style="background-color: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="background-color: #f8fafc; color: #475569; text-align: left; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 14px 20px; font-weight: 600; width: 80px;">Foto</th>
                    <th style="padding: 14px 20px; font-weight: 600;">Info Produk</th>
                    <th style="padding: 14px 20px; font-weight: 600;">Kategori</th>
                    <th style="padding: 14px 20px; font-weight: 600;">Harga Satuan</th>
                    <th style="padding: 14px 20px; font-weight: 600; text-align: center;">Sisa Stok</th>
                    <th style="padding: 14px 20px; font-weight: 600; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <!-- Kolom 1: Thumbnail Foto Produk -->
                        <td style="padding: 16px 20px; vertical-align: middle;">
                            @if($product->image)
                                <img src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}" style="width: 58px; height: 58px; object-fit: contain; border-radius: 8px; border: 1px solid #e2e8f0; background: #f8fafc; display: block; padding: 4px;">
                            @else
                                <div style="width: 58px; height: 58px; background-color: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 11px; color: #94a3b8; text-align: center;">
                                    No Img
                                </div>
                            @endif
                        </td>

                        <!-- Kolom 2: Nama & Cuplikan Spesifikasi -->
                        <td style="padding: 16px 20px; vertical-align: middle;">
                            <div style="font-weight: 700; color: #0f172a; font-size: 15px; margin-bottom: 4px;">
                                {{ $product->name }}
                            </div>
                            <div style="font-size: 13px; color: #64748b; max-width: 380px; line-height: 1.5;">
                                {{ \Illuminate\Support\Str::limit($product->description, 80) }}
                            </div>
                        </td>

                        <!-- Kolom 3: Kategori -->
                        <td style="padding: 16px 20px; vertical-align: middle;">
                            @if($product->category)
                                <span style="background-color: #eff6ff; color: #0B5ED7; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; border: 1px solid #bfdbfe;">
                                    {{ $product->category->name }}
                                </span>
                            @else
                                <span style="color: #94a3b8; font-size: 12px;">- Tanpa Kategori -</span>
                            @endif
                        </td>

                        <!-- Kolom 4: Harga Produk -->
                        <td style="padding: 16px 20px; vertical-align: middle; font-weight: 700; color: #0f172a; font-size: 15px;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <!-- Kolom 5: Sisa Stok (Fitur Inovasi P12) -->
                        <td style="padding: 16px 20px; vertical-align: middle; text-align: center;">
                            @if($product->stock <= 0)
                                <span style="background-color: #fee2e2; color: #dc2626; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; border: 1px solid #fca5a5;">
                                    Habis (0)
                                </span>
                            @elseif($product->stock <= 5)
                                <span style="background-color: #fef3c7; color: #d97706; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; border: 1px solid #fde68a;">
                                    Menipis ({{ $product->stock }})
                                </span>
                            @else
                                <span style="background-color: #ecfdf5; color: #059669; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; border: 1px solid #a7f3d0;">
                                    {{ $product->stock }} unit
                                </span>
                            @endif
                        </td>

                        <!-- Kolom 6: Aksi -->
                        <td style="padding: 16px 20px; vertical-align: middle; text-align: right;">
                            <div style="display: inline-flex; gap: 8px; align-items: center;">
                                <a href="/detail/{{ $product->id }}" target="_blank" style="color: #475569; text-decoration: none; font-weight: 600; font-size: 13px; background-color: #f8fafc; padding: 7px 12px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                    Lihat &nearr;
                                </a>

                                <a href="/admin/products/{{ $product->id }}/edit" style="color: #0B5ED7; text-decoration: none; font-weight: 600; font-size: 13px; background-color: #eff6ff; padding: 7px 14px; border-radius: 6px; border: 1px solid #bfdbfe;">
                                    Edit
                                </a>

                                <form action="/admin/products/{{ $product->id }}/delete" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->name }} secara permanen?');" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="color: #dc2626; background-color: #fef2f2; border: 1px solid #fecaca; padding: 7px 12px; border-radius: 6px; font-weight: 600; font-size: 13px; font-family: inherit; cursor: pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 48px 20px; color: #64748b;">
                            Belum ada produk di etalase. Klik tombol <strong>+ Tambah Produk Baru</strong> untuk mulai mengunggah barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
