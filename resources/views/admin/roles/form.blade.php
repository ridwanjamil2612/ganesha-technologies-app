@extends('admin.layout')
@section('title', ($role->exists ? 'Edit' : 'Tambah') . ' Peran')

@section('content')
    <div class="adm-toolbar">
        <h1>{{ $role->exists ? 'Edit' : 'Tambah' }} Peran</h1>
        <a class="adm-btn" href="{{ route('admin.roles.index') }}">← Kembali</a>
    </div>

    <form method="POST"
          action="{{ $role->exists ? route('admin.roles.update', $role->id) : route('admin.roles.store') }}"
          class="adm-form">
        @csrf
        @if ($role->exists) @method('PUT') @endif

        <div class="adm-field">
            <label for="r_label">Nama peran</label>
            <input id="r_label" type="text" name="label" value="{{ old('label', $role->label) }}" placeholder="mis. Editor Berita, Manajer Konten">
            @error('label') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-field">
            <label>Hak akses fitur (centang yang diizinkan)</label>
            @php
                $selected = old('permissions', $role->permissions ?? []);
                $groups = ['Konten' => [], 'Fitur lain' => []];
                foreach ($perms as $key => $label) {
                    $g = str_starts_with($key, 'content.') ? 'Konten' : 'Fitur lain';
                    $groups[$g][$key] = $label;
                }
            @endphp
            @foreach ($groups as $gname => $items)
                @if ($items)
                    <p class="perm-group">{{ $gname }}</p>
                    <div class="perm-list">
                        @foreach ($items as $key => $label)
                            <label class="perm-item">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" @checked(in_array($key, $selected))>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            @endforeach
            @error('permissions') <small class="adm-error">{{ $message }}</small> @enderror
        </div>

        <div class="adm-form-actions">
            <button type="submit" class="adm-btn adm-btn-primary">Simpan</button>
            <a class="adm-btn" href="{{ route('admin.roles.index') }}">Batal</a>
        </div>
    </form>
@endsection
