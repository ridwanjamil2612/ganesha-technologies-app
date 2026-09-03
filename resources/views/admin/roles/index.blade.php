@extends('admin.layout')
@section('title', 'Peran & Akses')

@section('content')
    <div class="adm-toolbar">
        <h1>Peran &amp; Akses</h1>
        <a class="adm-btn adm-btn-primary" href="{{ route('admin.roles.create') }}">+ Tambah Peran</a>
    </div>

    <p class="adm-hint" style="margin-bottom:1rem">Buat peran sesuai kebutuhan, lalu centang fitur yang boleh diakses. Setiap pengguna diberi salah satu peran di menu <b>Kelola User</b>.</p>

    <div class="role-cards">
        @foreach ($roles as $role)
            <div class="role-card">
                <div class="role-card-head">
                    <div>
                        <h3>{{ $role->label }}</h3>
                        <small>{{ $counts[$role->id] ?? 0 }} pengguna</small>
                    </div>
                    @if ($role->is_system)
                        <span class="role-badge role-admin">Sistem</span>
                    @endif
                </div>

                <ul class="role-perms">
                    @if (in_array('*', $role->permissions ?? []))
                        <li class="on">Akses penuh (semua fitur)</li>
                    @else
                        @foreach ($perms as $key => $label)
                            <li class="{{ in_array($key, $role->permissions ?? []) ? 'on' : 'off' }}">
                                {{ in_array($key, $role->permissions ?? []) ? '✓' : '✕' }} {{ $label }}
                            </li>
                        @endforeach
                    @endif
                </ul>

                @unless ($role->is_system)
                    <div class="role-card-actions">
                        <a class="adm-btn" href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}"
                              onsubmit="return confirm('Hapus peran ini?')" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="adm-btn adm-btn-danger" type="submit">Hapus</button>
                        </form>
                    </div>
                @endunless
            </div>
        @endforeach
    </div>
@endsection
