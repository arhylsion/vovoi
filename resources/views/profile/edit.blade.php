@extends('layouts.master')

@section('title', 'Profil Pengguna - VOVOI')

@section('konten_utama')
<div style="max-width: 900px; margin: 0 auto; padding: 12px 0 60px;">
    <!-- Breadcrumb -->
    <nav style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748b; margin-bottom: 24px;">
        <a href="/" style="color: #0B5ED7; text-decoration: none; font-weight: 500;">Beranda</a>
        <span>&rsaquo;</span>
        <span style="color: #0f172a; font-weight: 700;">Profil Pengguna</span>
    </nav>

    <!-- Header Section -->
    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); color: #ffffff; padding: 28px 32px; border-radius: 14px; margin-bottom: 28px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <span style="background: rgba(255, 255, 255, 0.15); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px;">
                AKUN CUSTOMER RESMI VOVOI
            </span>
            <h1 style="margin: 8px 0 4px 0; font-size: 24px; font-weight: 800;">
                Halo, {{ $user->name }}
            </h1>
            <p style="margin: 0; font-size: 13px; color: #cbd5e1;">
                {{ $user->email }} &bull; Bergabung sejak {{ $user->created_at ? $user->created_at->format('M Y') : '2026' }}
            </p>
        </div>
        <div>
            <form action="/logout" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: rgba(239, 68, 68, 0.2); color: #fecaca; border: 1px solid rgba(239, 68, 68, 0.4); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer;">
                    Keluar Sesi
                </button>
            </form>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div style="background-color: #ecfdf5; color: #065f46; padding: 14px 18px; border-radius: 10px; border: 1px solid #a7f3d0; margin-bottom: 24px; font-size: 14px; font-weight: 600;">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background-color: #fef2f2; color: #991b1b; padding: 14px 18px; border-radius: 10px; border: 1px solid #fecaca; margin-bottom: 24px; font-size: 14px;">
            <strong style="display: block; margin-bottom: 6px;">Pembaruan profil belum berhasil:</strong>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Profil -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 32px; margin-bottom: 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 800; color: #0f172a;">
            Informasi Akun &amp; Alamat Pengiriman Default
        </h3>
        <p style="margin: 0 0 24px 0; font-size: 13px; color: #64748b;">
            Data di bawah ini akan otomatis digunakan untuk melengkapi formulir checkout pesanan Anda.
        </p>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        Nama Lengkap <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit;">
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        Alamat Email (Akun)
                    </label>
                    <input type="email" value="{{ $user->email }}" disabled style="width: 100%; padding: 11px 14px; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 8px; font-size: 14px; font-family: inherit; color: #64748b; cursor: not-allowed;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                    Nomor WhatsApp / HP Aktif
                </label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit;">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                    Alamat Pengiriman Default
                </label>
                <textarea name="address" rows="3" placeholder="Tuliskan alamat lengkap pengiriman untuk auto-fill saat checkout..." style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit; line-height: 1.5;">{{ old('address', $user->address) }}</textarea>
            </div>

            <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 28px 0;">

            <h4 style="margin: 0 0 6px 0; font-size: 15px; font-weight: 700; color: #0f172a;">
                Ganti Kata Sandi (Opsional)
            </h4>
            <p style="margin: 0 0 16px 0; font-size: 13px; color: #64748b;">
                Kosongkan kedua isian berikut apabila Anda tidak ingin mengubah kata sandi akun saat ini.
            </p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        Kata Sandi Baru
                    </label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter..." style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit;">
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        Ulangi Kata Sandi Baru
                    </label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru..." style="width: 100%; padding: 11px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit;">
                </div>
            </div>

            <div style="text-align: right;">
                <button type="submit" style="background-color: #0B5ED7; color: #ffffff; border: none; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 700; font-family: inherit; cursor: pointer; transition: background 0.15s ease;">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- Riwayat Transaksi Akun -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
            <div>
                <h3 style="margin: 0 0 4px 0; font-size: 18px; font-weight: 800; color: #0f172a;">
                    Riwayat Pesanan Anda
                </h3>
                <p style="margin: 0; font-size: 13px; color: #64748b;">
                    Daftar pesanan yang pernah Anda lakukan menggunakan akun ini.
                </p>
            </div>
            <a href="/pesanan-saya" style="font-size: 13px; font-weight: 700; color: #0B5ED7; text-decoration: none;">
                Buka Halaman Pesanan Saya &rarr;
            </a>
        </div>

        @if($orders->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left; color: #475569;">
                            <th style="padding: 10px 14px;">No Invoice</th>
                            <th style="padding: 10px 14px;">Waktu</th>
                            <th style="padding: 10px 14px;">Produk</th>
                            <th style="padding: 10px 14px;">Total Bayar</th>
                            <th style="padding: 10px 14px; text-align: center;">Status</th>
                            <th style="padding: 10px 14px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $ord)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 12px 14px; font-weight: 700; color: #0B5ED7;">{{ $ord->invoice_code }}</td>
                                <td style="padding: 12px 14px; color: #64748b;">{{ $ord->created_at ? $ord->created_at->format('d M Y') : '-' }}</td>
                                <td style="padding: 12px 14px;">{{ $ord->product_name }}</td>
                                <td style="padding: 12px 14px; font-weight: 700;">Rp {{ number_format($ord->total_amount, 0, ',', '.') }}</td>
                                <td style="padding: 12px 14px; text-align: center;">
                                    @if($ord->status == 'Pending')
                                        <span style="background: #fef3c7; color: #92400e; padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 11px;">Pending</span>
                                    @elseif($ord->status == 'Paid')
                                        <span style="background: #dbeafe; color: #1e40af; padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 11px;">Paid</span>
                                    @elseif($ord->status == 'Shipped')
                                        <span style="background: #dcfce7; color: #166534; padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 11px;">Shipped</span>
                                    @elseif($ord->status == 'Cancelled')
                                        <span style="background: #fee2e2; color: #991b1b; padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 11px;">Cancelled</span>
                                    @else
                                        <span>{{ $ord->status }}</span>
                                    @endif
                                </td>
                                <td style="padding: 12px 14px; text-align: right;">
                                    <a href="/berhasil/{{ $ord->id }}" style="color: #0B5ED7; text-decoration: none; font-weight: 700; font-size: 12px;">
                                        Lihat E-Invoice &rarr;
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 32px; color: #64748b; background: #f8fafc; border-radius: 8px;">
                Belum ada pesanan yang tercatat untuk akun ini. Jelajahi katalog dan pesan produk pilihan Anda!
            </div>
        @endif
    </div>
</div>
@endsection
