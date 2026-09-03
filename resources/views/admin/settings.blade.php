@extends('admin.layout')
@section('title', 'Pengaturan Perusahaan')

@section('content')
    <div class="adm-toolbar">
        <h1>Pengaturan Perusahaan</h1>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="adm-form">
        @csrf @method('PUT')

        @php
            $fields = [
                ['name', 'Nama perusahaan', 'text'],
                ['short', 'Nama singkat', 'text'],
                ['tagline', 'Tagline', 'textarea'],
                ['tagline_en', 'Tagline (English)', 'textarea'],
                ['desc', 'Deskripsi', 'textarea'],
                ['desc_en', 'Deskripsi (English)', 'textarea'],
                ['email', 'Email', 'email'],
                ['phone', 'Telepon', 'text'],
                ['whatsapp', 'WhatsApp (format 62…)', 'text'],
                ['address', 'Alamat', 'textarea'],
                ['hours', 'Jam operasional', 'text'],
                ['founded', 'Tahun berdiri', 'number'],
                ['video_url', 'Video profil (link YouTube)', 'text'],
            ];
        @endphp

        @foreach ($fields as [$name, $label, $type])
            @php $value = old($name, $setting->{$name} ?? ''); @endphp
            <div class="adm-field">
                <label for="s_{{ $name }}">{{ $label }}</label>
                @if ($type === 'textarea')
                    <textarea id="s_{{ $name }}" name="{{ $name }}" rows="3">{{ $value }}</textarea>
                @else
                    <input id="s_{{ $name }}" type="{{ $type === 'number' ? 'number' : ($type === 'email' ? 'email' : 'text') }}"
                           name="{{ $name }}" value="{{ $value }}">
                @endif
                @error($name) <small class="adm-error">{{ $message }}</small> @enderror
            </div>
        @endforeach

        <div class="adm-form-actions">
            <button type="submit" class="adm-btn adm-btn-primary">Simpan</button>
        </div>
    </form>
@endsection
