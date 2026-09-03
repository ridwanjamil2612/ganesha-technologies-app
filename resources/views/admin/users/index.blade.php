@extends('admin.layout')
@section('title', 'Kelola User')

@section('content')
    <div class="adm-toolbar">
        <h1>Kelola User</h1>
        <a class="adm-btn adm-btn-primary" href="{{ route('admin.users.create') }}">+ Tambah Pengguna</a>
    </div>

    <table class="adm-table">
        <thead><tr><th>Nama</th><th>Email</th><th>Peran</th><th></th></tr></thead>
        <tbody>
            @foreach ($users as $u)
                <tr>
                    <td>{{ $u->name }} @if ($u->id === auth()->id())<small style="color:var(--muted)">(Anda)</small>@endif</td>
                    <td>{{ $u->email }}</td>
                    <td><span class="role-badge role-admin">{{ $roles[$u->role_id] ?? '—' }}</span></td>
                    <td class="adm-row-actions">
                        <a class="adm-btn" href="{{ route('admin.users.edit', $u->id) }}">Edit</a>
                        @if ($u->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}"
                                  onsubmit="return confirm('Hapus pengguna ini?')" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="adm-btn adm-btn-danger" type="submit">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
