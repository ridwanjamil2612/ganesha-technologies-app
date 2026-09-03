@extends('admin.layout')
@section('title', ($item->exists ? 'Edit ' : 'Tambah ') . $def['singular'])

@section('content')
    <div class="adm-toolbar">
        <h1>{{ $item->exists ? 'Edit' : 'Tambah' }} {{ $def['singular'] }}</h1>
        <a class="adm-btn" href="{{ route('admin.resource.index', $resource) }}">← Kembali</a>
    </div>

    <form method="POST"
          action="{{ $item->exists ? route('admin.resource.update', [$resource, $item->id]) : route('admin.resource.store', $resource) }}"
          class="adm-form" enctype="multipart/form-data">
        @csrf
        @if ($item->exists) @method('PUT') @endif

        @foreach ($def['fields'] as $f)
            @php
                $name = $f['name'];
                $type = $f['type'];
                $cur  = $item->{$name} ?? null;
                if ($type === 'kvlines') {
                    $display = is_array($cur) ? collect($cur)->map(fn ($v, $k) => "$k: $v")->implode("\n") : '';
                } elseif ($type === 'paragraphs') {
                    $display = is_array($cur) ? implode("\n\n", $cur) : '';
                } elseif ($type === 'date') {
                    $display = $cur ? \Illuminate\Support\Carbon::parse($cur)->format('Y-m-d') : '';
                } else {
                    $display = is_scalar($cur) ? $cur : '';
                }
                $value = old($name, $display);
            @endphp

            <div class="adm-field">
                <label for="f_{{ $name }}">{{ $f['label'] }}</label>

                @if ($type === 'textarea')
                    <textarea id="f_{{ $name }}" name="{{ $name }}" rows="4">{{ $value }}</textarea>
                @elseif ($type === 'kvlines')
                    <textarea id="f_{{ $name }}" name="{{ $name }}" rows="7" class="mono">{{ $value }}</textarea>
                @elseif ($type === 'paragraphs')
                    <textarea id="f_{{ $name }}" name="{{ $name }}" rows="9">{{ $value }}</textarea>
                @elseif ($type === 'select')
                    <select id="f_{{ $name }}" name="{{ $name }}">
                        @foreach ($f['options'] as $ov => $ol)
                            <option value="{{ $ov }}" @selected($value === $ov)>{{ $ol }}</option>
                        @endforeach
                    </select>
                @elseif ($type === 'image')
                    @if ($cur)
                        <img src="{{ asset('storage/' . $cur) }}" alt=""
                             style="max-width:220px;border-radius:6px;margin-bottom:.5rem;display:block;border:1px solid var(--line)">
                    @endif
                    <input id="f_{{ $name }}" type="file" name="{{ $name }}" accept="image/*">
                @elseif ($type === 'images')
                    @php $imgs = is_array($cur) ? $cur : []; @endphp
                    @if ($imgs)
                        <div class="adm-imggrid">
                            @foreach ($imgs as $img)
                                <label class="adm-imgitem">
                                    <img src="{{ asset('storage/' . $img) }}" alt="">
                                    <span><input type="checkbox" name="{{ $name }}_delete[]" value="{{ $img }}"> Hapus</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                    <input id="f_{{ $name }}" type="file" name="{{ $name }}[]" accept="image/*" multiple>
                @else
                    <input id="f_{{ $name }}" type="{{ $type === 'number' ? 'number' : ($type === 'date' ? 'date' : 'text') }}"
                           name="{{ $name }}" value="{{ $value }}">
                @endif

                @isset($f['hint'])
                    <small class="adm-hint">{{ $f['hint'] }}</small>
                @endisset
                @error($name) <small class="adm-error">{{ $message }}</small> @enderror
            </div>
        @endforeach

        @isset($def['seo'])
            @php $sc = $def['seo']; @endphp
            <div class="adm-field">
                <label>Analisis SEO (langsung)</label>
                <div class="seo-live"
                     data-title="{{ $sc['title'] ?? '' }}"
                     data-desc="{{ $sc['desc'] ?? '' }}"
                     data-slug="{{ $sc['slug'] ?? '' }}"
                     data-content="{{ $sc['content'] ?? '' }}"
                     data-image="{{ $sc['image'] ?? '' }}"
                     data-has-image="{{ !empty($sc['image']) && !empty($item->{$sc['image']}) ? 1 : 0 }}"
                     data-title-min="25" data-title-max="65"
                     data-desc-min="50" data-desc-max="160"
                     data-content-min="150">
                    <div class="seo-live-top">
                        <input type="text" class="seo-kw" placeholder="Kata kunci fokus (opsional) — mis. insinerator rumah sakit">
                        <div class="seo-live-badge"><span class="seo-live-num">0</span><small>/100</small></div>
                    </div>
                    <ul class="seo-live-list"></ul>
                </div>
            </div>
        @endisset

        <div class="adm-form-actions">
            <button type="submit" class="adm-btn adm-btn-primary">Simpan</button>
            <a class="adm-btn" href="{{ route('admin.resource.index', $resource) }}">Batal</a>
        </div>
    </form>

    @isset($def['seo'])
        <script src="{{ asset('js/admin-seo.js') }}"></script>
    @endisset
@endsection
