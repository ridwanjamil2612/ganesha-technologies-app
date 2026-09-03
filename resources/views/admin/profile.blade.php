@extends('admin.layout')
@section('title', 'Akun')

@section('content')
    <div class="adm-toolbar">
        <h1>Akun</h1>
    </div>

    <form method="POST" action="{{ route('admin.profile.update') }}" class="adm-form">
        @csrf @method('PUT')

        <div class="adm-field">
            <label for="p_name">Nama</label>
            <input id="p_name" type="text" name="name" value="{{ old('name', $user->name) }}">
            @error('name') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-field">
            <label for="p_email">Email (untuk login)</label>
            <input id="p_email" type="email" name="email" value="{{ old('email', $user->email) }}">
            @error('email') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-field">
            <label for="p_password">Kata sandi baru</label>
            <input id="p_password" type="password" name="password" autocomplete="new-password">
            <small class="adm-hint">Kosongkan bila tidak ingin mengubah. Minimal 8 karakter.</small>
            @error('password') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-field">
            <label for="p_password_confirmation">Ulangi kata sandi baru</label>
            <input id="p_password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
        </div>

        <div class="adm-form-actions">
            <button type="submit" class="adm-btn adm-btn-primary">Simpan</button>
        </div>
    </form>
@endsection
