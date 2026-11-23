@extends('layouts.admin')

@section('konten_admin')
    <!-- 1. FLASH NOTIFICATION -->
    @if(session('success'))
        <div style="background-color: #ecfdf5; color: #065f46; padding: 14px 18px; border-radius: 10px; border: 1px solid #a7f3d0; margin-bottom: 24px; font-size: 14px; font-weight: 600;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- 2. HEADER & ACTION BUTTON -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="margin: 0; font-size: 22px; font-weight: 700; color: #0f172a;">Manajemen Kategori Produk</h2>
            <p style="margin: 4px 0 0 0; font-size: 14px; color: #64748b;">
                Kelola kategori untuk pengelompokan produk dan filter katalog di etalase toko.
            </p>
        </div>
        <a href="{{ route('admin.categories.create') }}" style="background-color: #0B5ED7; color: #ffffff; text-decoration: none; padding: 11px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <span>+</span> Tambah Kategori Baru
        </a>
    </div>

    <!-- 3. TABEL KATEGORI -->
    <div style="background-color: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="background-color: #f8fafc; color: #475569; text-align: left; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 14px 20px; font-weight: 600; width: 60px;">No.</th>
                    <th style="padding: 14px 20px; font-weight: 600;">Nama Kategori</th>
                    <th style="padding: 14px 20px; font-weight: 600;">Slug URL</th>
                    <th style="padding: 14px 20px; font-weight: 600;">Deskripsi</th>
                    <th style="padding: 14px 20px; font-weight: 600; text-align: center;">Jumlah Produk</th>
                    <th style="padding: 14px 20px; font-weight: 600; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $cat)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 16px 20px; color: #64748b; font-weight: 600;">{{ $index + 1 }}</td>
                        <td style="padding: 16px 20px; font-weight: 700; color: #0f172a;">
                            {{ $cat->name }}
                        </td>
                        <td style="padding: 16px 20px; font-family: monospace; font-size: 12px; color: #0B5ED7;">
                            /katalog?category={{ $cat->slug }}
                        </td>
                        <td style="padding: 16px 20px; color: #64748b; max-width: 320px; line-height: 1.4;">
                            {{ $cat->description ?: '-' }}
                        </td>
                        <td style="padding: 16px 20px; text-align: center;">
                            <span style="background-color: #eff6ff; color: #0B5ED7; padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 12px; border: 1px solid #bfdbfe;">
                                {{ $cat->products_count }} Produk
                            </span>
                        </td>
                        <td style="padding: 16px 20px; text-align: right;">
                            <div style="display: inline-flex; gap: 8px; align-items: center;">
                                <a href="{{ route('admin.categories.edit', $cat->id) }}" style="color: #0B5ED7; text-decoration: none; font-weight: 600; font-size: 13px; background-color: #eff6ff; padding: 6px 14px; border-radius: 6px; border: 1px solid #bfdbfe;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $cat->name }}?');" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="color: #dc2626; background-color: #fef2f2; border: 1px solid #fecaca; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 13px; font-family: inherit; cursor: pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 48px 20px; color: #64748b;">
                            Belum ada kategori yang dibuat. Klik tombol <strong>+ Tambah Kategori Baru</strong>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
