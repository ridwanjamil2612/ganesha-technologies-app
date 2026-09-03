@extends('admin.layout')
@section('title', 'Pesan Masuk')

@section('content')
    <div class="adm-toolbar">
        <h1>Pesan Masuk <span class="adm-count">{{ $messages->total() }}</span></h1>
        @if ($messages->total() > 0)
            <a class="adm-btn adm-btn-primary" href="{{ route('admin.messages.export') }}">⬇ Unduh CSV</a>
        @endif
    </div>
    @if ($messages->isEmpty())
        <div class="adm-empty">Belum ada pesan masuk dari formulir kontak.</div>
    @else
        <div class="adm-tablewrap">
            <table class="adm-table">
                <thead>
                    <tr><th>Status</th><th>Nama</th><th>Instansi</th><th>No HP</th><th>Tanggal</th><th class="adm-actions-h">Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach ($messages as $m)
                        <tr style="{{ $m->is_read ? '' : 'background:#F3F9E9' }}">
                            <td>
                                @if ($m->is_read)
                                    <span class="msg-dot read" title="Sudah dibaca"></span>                                @else
                                    <span class="msg-dot unread" title="Belum dibaca"></span>
                                @endif
                            </td>
                            <td><b>{{ $m->name }}</b></td>
                            <td>{{ $m->instansi ?: '—' }}</td>
                            <td>{{ $m->phone }}</td>
                            <td>{{ $m->created_at->translatedFormat('d M Y, H:i') }}</td>
                            <td class="adm-actions">
                                <a class="adm-link" href="{{ route('admin.messages.show', $m->id) }}">Lihat</a>
                                <form method="POST" action="{{ route('admin.messages.destroy', $m->id) }}"
                                      onsubmit="return confirm('Hapus pesan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="adm-link danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem">{{ $messages->links() }}</div>
    @endif
@endsection
