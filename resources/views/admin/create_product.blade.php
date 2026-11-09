@extends('layouts.admin')

@section('konten_admin')
    <!-- 1. BREADCRUMB SELLER CENTER -->
    <div style="margin-bottom: 20px; font-size: 13px; color: #64748b; font-weight: 500;">
        <a href="/admin/products" style="color: #0B5ED7; text-decoration: none;">Katalog Produk</a>
        <span style="margin: 0 8px;">/</span>
        <span style="color: #0f172a; font-weight: 600;">Tambah Produk Baru</span>
    </div>

    <!-- 2. PESAN PERINGATAN JIKA VALIDASI GAGAL (Misal file bukan gambar atau > 2MB) -->
    @if($errors->any())
        <div style="background-color: #fef2f2; color: #991b1b; padding: 16px 20px; border-radius: 10px; border: 1px solid #fecaca; margin-bottom: 24px; font-size: 14px;">
            <strong style="display: block; margin-bottom: 6px;">Gagal menyimpan produk, periksa kembali isian berikut:</strong>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 3. KARTU FORMULIR TAMBAH PRODUK -->
    <div style="background-color: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 32px;">
        <div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 28px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #0f172a;">Informasi & Media Produk</h2>
            <p style="margin: 4px 0 0 0; font-size: 13px; color: #64748b;">
                Pastikan foto produk memiliki pencahayaan yang baik dan spesifikasi ditulis secara jelas.
            </p>
        </div>

        <!-- WAJIB: Gunakan method="POST" dan enctype="multipart/form-data" untuk Upload File -->
        <form action="/admin/products/store" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: flex; gap: 36px; align-items: flex-start;">
                <!-- KOLOM KIRI (35%): AREA UPLOAD FOTO & PREVIEW -->
                <div style="width: 35%;">
                    <label style="font-weight: 600; font-size: 14px; color: #0f172a; display: block; margin-bottom: 6px;">
                        Foto Produk Utama <span style="color: #ef4444;">*</span>
                    </label>
                    <p style="font-size: 12px; color: #64748b; margin-top: 0; margin-bottom: 12px; line-height: 1.5;">
                        Format yang didukung: <strong>JPG, JPEG, PNG, WEBP</strong>. Ukuran maksimal <strong>2 MB</strong>.
                    </p>

                    <!-- Kotak Pratinjau Gambar -->
                    <div style="border: 2px dashed #cbd5e1; border-radius: 10px; padding: 20px; text-align: center; background-color: #f8fafc; margin-bottom: 12px;">
                        <img id="previewImage" src="" alt="Pratinjau Foto" style="display: none; width: 100%; height: 220px; object-fit: cover; border-radius: 8px; margin-bottom: 12px; border: 1px solid #e2e8f0;">

                        <div id="placeholderText" style="padding: 40px 10px; color: #64748b; font-size: 13px;">
                            Belum ada foto dipilih.<br>Klik tombol di bawah untuk mengunggah foto produk.
                        </div>

                        <input type="file" name="image" id="imageInput" accept="image/png, image/jpeg, image/jpg, image/webp" required onchange="previewFile(this)" style="width: 100%; font-size: 13px; color: #475569;">
                    </div>
                </div>

                <!-- KOLOM KANAN (65%): SPESIFIKASI TEKS & HARGA -->
                <div style="width: 65%;">
                    <div style="margin-bottom: 20px;">
                        <label style="font-weight: 600; font-size: 14px; color: #0f172a; display: block; margin-bottom: 8px;">
                            Nama Produk <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Sepatu Running Ortuseight Hyperblast 2.0" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="font-weight: 600; font-size: 14px; color: #0f172a; display: block; margin-bottom: 8px;">
                            Harga Satuan (Rupiah) <span style="color: #ef4444;">*</span>
                        </label>
                        <div style="display: flex; align-items: center; border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; background-color: #f8fafc;">
                            <span style="padding: 12px 16px; font-weight: 700; color: #475569; font-size: 14px; border-right: 1px solid #cbd5e1;">Rp</span>
                            <input type="number" name="price" value="{{ old('price') }}" min="100" placeholder="Contoh: 550000 (Ketik angka tanpa titik)" required style="width: 100%; padding: 12px 14px; border: none; font-size: 14px; font-family: inherit; outline: none; background: #ffffff;">
                        </div>
                    </div>

                    <div style="margin-bottom: 28px;">
                        <label style="font-weight: 600; font-size: 14px; color: #0f172a; display: block; margin-bottom: 8px;">
                            Deskripsi & Spesifikasi Lengkap <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea name="description" rows="6" placeholder="Tuliskan spesifikasi lengkap, ukuran, garansi, dan keunggulan produk..." required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit; line-height: 1.6;">{{ old('description') }}</textarea>
                    </div>

                    <!-- Tombol Batal & Simpan -->
                    <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                        <a href="/admin/products" style="padding: 12px 24px; border-radius: 8px; border: 1px solid #cbd5e1; color: #475569; text-decoration: none; font-size: 14px; font-weight: 600;">
                            Batal
                        </a>
                        <button type="submit" style="padding: 12px 28px; border-radius: 8px; border: none; background-color: #0B5ED7; color: #ffffff; font-size: 14px; font-weight: 600; font-family: inherit; cursor: pointer;">
                            Simpan & Tampilkan Produk
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Script Ringan untuk Menampilkan Pratinjau Foto Sebelum Di-upload -->
    <script>
        function previewFile(input) {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.getElementById('previewImage');
                    var txt = document.getElementById('placeholderText');
                    img.src = e.target.result;
                    img.style.display = 'block';
                    txt.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection

