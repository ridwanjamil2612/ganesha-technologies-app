@extends('admin.layout')
@section('title', ($user->exists ? 'Edit' : 'Tambah') . ' Pengguna')

@section('content')
    <div class="adm-toolbar">
        <h1>{{ $user->exists ? 'Edit' : 'Tambah' }} Pengguna</h1>
        <a class="adm-btn" href="{{ route('admin.users.index') }}">← Kembali</a>
    </div>

    <form method="POST"
          action="{{ $user->exists ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
          class="adm-form">
        @csrf
        @if ($user->exists) @method('PUT') @endif

        <div class="adm-field">
            <label for="u_name">Nama</label>
            <input id="u_name" type="text" name="name" value="{{ old('name', $user->name) }}">
            @error('name') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-field">
            <label for="u_email">Email</label>
            <input id="u_email" type="email" name="email" value="{{ old('email', $user->email) }}">
            @error('email') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-field">
            <label for="u_password">Password</label>
            <input id="u_password" type="password" name="password" autocomplete="new-password">
            <small class="adm-hint">{{ $user->exists ? 'Kosongkan bila tidak ingin mengubah password.' : 'Minimal 6 karakter.' }}</small>
            @error('password') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-field">
            <label for="u_role">Peran</label>
            <select id="u_role" name="role_id">
                @foreach ($roles as $r)
                    <option value="{{ $r->id }}" @selected((int) old('role_id', $user->role_id) === $r->id)>{{ $r->label }}</option>
                @endforeach
            </select>
            <small class="adm-hint">Atur hak akses tiap peran di menu <b>Peran &amp; Akses</b>.</small>
            @error('role_id') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-form-actions">
            <button type="submit" class="adm-btn adm-btn-primary">Simpan</button>
            <a class="adm-btn" href="{{ route('admin.users.index') }}">Batal</a>
        </div>
    </form>
@endsection
