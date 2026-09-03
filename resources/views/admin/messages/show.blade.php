@extends('admin.layout')
@section('title', 'Detail Pesan')

@section('content')
    <div class="adm-toolbar">
        <h1>Detail Pesan</h1>
        <a class="adm-btn" href="{{ route('admin.messages.index') }}">← Kembali</a>
    </div>

    <div class="panel" style="max-width:720px">
        <dl class="msg-detail">
            <div><dt>Nama Lengkap</dt><dd>{{ $message->name }}</dd></div>
            <div><dt>Instansi</dt><dd>{{ $message->instansi ?: '—' }}</dd></div>
            <div><dt>No HP</dt><dd>{{ $message->phone }}</dd></div>
            <div><dt>Email</dt><dd>{{ $message->email ?: '—' }}</dd></div>
            <div><dt>Waktu</dt><dd>{{ $message->created_at->translatedFormat('d F Y, H:i') }} WIB</dd></div>
        </dl>

        <div class="msg-body">
            <h4>Kebutuhan Spesifik</h4>
            <p>{{ $message->message }}</p>
        </div>

        <div class="adm-form-actions">
            <a class="adm-btn adm-btn-primary" target="_blank" rel="noopener" href="{{ $message->customerWaLink() }}">
                Balas via WhatsApp
            </a>
            <a class="adm-btn" href="mailto:{{ $message->email }}" @disabled(!$message->email)>Balas via Email</a>
            <form method="POST" action="{{ route('admin.messages.destroy', $message->id) }}"
                  onsubmit="return confirm('Hapus pesan ini?')" style="margin-left:auto">
                @csrf @method('DELETE')
                <button class="adm-btn" type="submit" style="color:var(--danger)">Hapus</button>
            </form>
        </div>
    </div>
@endsection
