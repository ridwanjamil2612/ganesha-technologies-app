@extends('admin.layout')
@section('title', ($brochure->exists ? 'Edit' : 'Tambah') . ' Brosur')

@section('content')
    <div class="adm-toolbar">
        <h1>{{ $brochure->exists ? 'Edit' : 'Tambah' }} Brosur</h1>
        <a class="adm-btn" href="{{ route('admin.brochures.index') }}">← Kembali</a>
    </div>

    <form method="POST"
          action="{{ $brochure->exists ? route('admin.brochures.update', $brochure->id) : route('admin.brochures.store') }}"
          class="adm-form" enctype="multipart/form-data">
        @csrf
        @if ($brochure->exists) @method('PUT') @endif

        <div class="adm-field">
            <label for="b_title">Judul Brosur</label>
            <input id="b_title" type="text" name="title" value="{{ old('title', $brochure->title) }}" placeholder="mis. Katalog Insinerator 2026">
            @error('title') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-field">
            <label for="b_file">File PDF</label>
            <input id="b_file" type="file" name="file" accept="application/pdf">
            <small class="adm-hint">
                Hanya file .pdf, maksimal 10 MB.
                @if ($brochure->exists && $brochure->file)
                    Saat ini: <a href="{{ asset('storage/' . $brochure->file) }}" target="_blank" rel="noopener">lihat PDF</a>. Kosongkan bila tidak ingin mengubah.
                @endif
            </small>
            @error('file') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-field">
            <label for="b_thumb">Gambar Sampul (thumbnail) — opsional</label>
            <input id="b_thumb" type="file" name="thumb" accept="image/*">
            <small class="adm-hint">
                Gambar sampul yang tampil di tombol unduh (mis. tangkapan halaman depan brosur). JPG/PNG/WebP, maks 3 MB.
                @if ($brochure->exists && $brochure->thumb)
                    <br>Saat ini: <a href="{{ asset('storage/' . $brochure->thumb) }}" target="_blank" rel="noopener">lihat gambar</a>.
                    <label style="display:inline-flex;gap:.35rem;align-items:center;margin-left:.5rem">
                        <input type="checkbox" name="thumb_delete" value="1"> Hapus gambar sampul
                    </label>
                @endif
            </small>
            @error('thumb') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-field">
            <label for="b_sort">Urutan tampil</label>
            <input id="b_sort" type="number" name="sort" value="{{ old('sort', $brochure->sort ?? 0) }}" style="max-width:120px">
            <small class="adm-hint">Angka lebih kecil tampil lebih dulu.</small>
            @error('sort') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-form-actions">
            <button type="submit" class="adm-btn adm-btn-primary">Simpan</button>
            <a class="adm-btn" href="{{ route('admin.brochures.index') }}">Batal</a>
        </div>
    </form>
@endsection
