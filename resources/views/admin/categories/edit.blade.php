@extends('layouts.admin')

@section('konten_admin')
    <div style="margin-bottom: 20px; font-size: 13px; color: #64748b; font-weight: 500;">
        <a href="{{ route('admin.categories.index') }}" style="color: #0B5ED7; text-decoration: none;">Kategori</a>
        <span style="margin: 0 8px;">/</span>
        <span style="color: #0f172a; font-weight: 600;">Edit Kategori: {{ $category->name }}</span>
    </div>

    @if($errors->any())
        <div style="background-color: #fef2f2; color: #991b1b; padding: 16px 20px; border-radius: 10px; border: 1px solid #fecaca; margin-bottom: 24px; font-size: 14px;">
            <strong style="display: block; margin-bottom: 6px;">Gagal memperbarui kategori, periksa isian:</strong>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background-color: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 32px; max-width: 700px;">
        <div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 24px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #0f172a;">Edit Kategori Produk</h2>
            <p style="margin: 4px 0 0 0; font-size: 13px; color: #64748b;">
                Perbarui nama dan deskripsi kategori produk.
            </p>
        </div>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="font-weight: 600; font-size: 14px; color: #0f172a; display: block; margin-bottom: 8px;">
                    Nama Kategori <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit;">
            </div>

            <div style="margin-bottom: 28px;">
                <label style="font-weight: 600; font-size: 14px; color: #0f172a; display: block; margin-bottom: 8px;">
                    Deskripsi Kategori (Opsional)
                </label>
                <textarea name="description" rows="4" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; font-family: inherit; line-height: 1.6;">{{ old('description', $category->description) }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                <a href="{{ route('admin.categories.index') }}" style="padding: 12px 24px; border-radius: 8px; border: 1px solid #cbd5e1; color: #475569; text-decoration: none; font-size: 14px; font-weight: 600;">
                    Batal
                </a>
                <button type="submit" style="padding: 12px 28px; border-radius: 8px; border: none; background-color: #0B5ED7; color: #ffffff; font-size: 14px; font-weight: 600; font-family: inherit; cursor: pointer;">
                    Perbarui Kategori
                </button>
            </div>
        </form>
    </div>
@endsection
