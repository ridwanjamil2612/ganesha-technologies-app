@extends('admin.layout')
@section('title', 'Brosur')

@section('content')
    <div class="adm-toolbar">
        <h1>Brosur (PDF)</h1>
        <a class="adm-btn adm-btn-primary" href="{{ route('admin.brochures.create') }}">+ Tambah Brosur</a>
    </div>

    <p class="adm-hint" style="margin-bottom:1rem">Brosur yang diunggah di sini akan muncul sebagai tombol unduh di halaman <b>Produk &amp; Layanan</b>.</p>

    @if ($brochures->isEmpty())
        <div class="adm-empty">Belum ada brosur. Klik "Tambah Brosur" untuk mengunggah PDF.</div>
    @else
        <table class="adm-table">
            <thead><tr><th>Urutan</th><th>Sampul</th><th>Judul</th><th>File</th><th></th></tr></thead>
            <tbody>
                @foreach ($brochures as $b)
                    <tr>
                        <td>{{ $b->sort }}</td>
                        <td>
                            @if ($b->thumb)
                                <img src="{{ asset('storage/' . $b->thumb) }}" alt="" style="width:44px;height:56px;object-fit:cover;border-radius:4px;border:1px solid var(--line)">
                            @else
                                <span style="color:var(--muted)">—</span>
                            @endif
                        </td>
                        <td><b>{{ $b->title }}</b></td>
                        <td>
                            @if ($b->file)
                                <a class="adm-link" href="{{ asset('storage/' . $b->file) }}" target="_blank" rel="noopener">Lihat PDF</a>
                            @else
                                <span style="color:var(--muted)">—</span>
                            @endif
                        </td>
                        <td class="adm-row-actions">
                            <a class="adm-btn" href="{{ route('admin.brochures.edit', $b->id) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.brochures.destroy', $b->id) }}"
                                  onsubmit="return confirm('Hapus brosur ini?')" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="adm-btn adm-btn-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

