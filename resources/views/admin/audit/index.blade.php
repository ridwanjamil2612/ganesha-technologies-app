@extends('admin.layout')
@section('title', 'Log Aktivitas')

@section('content')
    <div class="adm-toolbar">
        <h1>Log Aktivitas</h1>
        @if ($logs->total() > 0)
            <form method="POST" action="{{ route('admin.audit.clear') }}"
                  onsubmit="return confirm('Bersihkan semua log yang lebih dari 90 hari?')" style="display:inline">
                @csrf
                <button class="adm-btn adm-btn-danger" type="submit">Bersihkan log &gt; 90 hari</button>
            </form>
        @endif
    </div>

    <p class="adm-hint" style="margin-bottom:1rem">Catatan aktivitas penting di panel admin (masuk/keluar &amp; perubahan data). Hanya-baca.</p>

    <div class="audit-filter">
        <a class="chip {{ !$action ? 'on' : '' }}" href="{{ route('admin.audit.index') }}">Semua</a>
        @foreach ($actions as $a)
            <a class="chip {{ $action === $a ? 'on' : '' }}" href="{{ route('admin.audit.index', ['action' => $a]) }}">{{ \App\Models\AuditLog::actionLabel($a) }}</a>
        @endforeach
    </div>

    @if ($logs->isEmpty())
        <div class="adm-empty">Belum ada aktivitas tercatat.</div>
    @else
        <div class="adm-tablewrap">
            <table class="adm-table">
                <thead>
                    <tr><th>Waktu</th><th>Pengguna</th><th>Aksi</th><th>Modul</th><th>Keterangan</th><th>IP</th></tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td style="white-space:nowrap">{{ \Illuminate\Support\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i') }}</td>
                            <td><b>{{ $log->user_name }}</b></td>
                            <td><span class="audit-badge a-{{ $log->action }}">{{ \App\Models\AuditLog::actionLabel($log->action) }}</span></td>
                            <td>{{ $log->module ?: '—' }}</td>
                            <td>{{ $log->description ?: '—' }}</td>
                            <td style="color:var(--muted)">{{ $log->ip }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem">{{ $logs->links() }}</div>
    @endif
@endsection
