@extends('admin.layout')
@section('title', $def['label'])

@section('content')
    <div class="adm-toolbar">
        <h1>{{ $def['label'] }} <span class="adm-count">{{ $rows->count() }}</span></h1>
        <a class="adm-btn adm-btn-primary" href="{{ route('admin.resource.create', $resource) }}">+ Tambah {{ $def['singular'] }}</a>
    </div>

    @if ($rows->isEmpty())
        <div class="adm-empty">Belum ada data. Klik “Tambah {{ $def['singular'] }}”.</div>
    @else
        <div class="adm-tablewrap">
            <table class="adm-table">
                <thead>
                <tr>
                    @foreach ($def['index'] as $col => $label)
                        <th>{{ $label }}</th>
                    @endforeach
                    <th class="adm-actions-h">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($rows as $row)
                    <tr>
                        @foreach ($def['index'] as $col => $label)
                            @php $val = data_get($row, $col); @endphp
                            <td>
                                @if ($val instanceof \Carbon\Carbon || $val instanceof \Illuminate\Support\Carbon)
                                    {{ $val->translatedFormat('d M Y') }}
                                @elseif (is_array($val))
                                    {{ count($val) }} item
                                @else
                                    {{ \Illuminate\Support\Str::limit((string) $val, 90) }}
                                @endif
                            </td>
                        @endforeach
                        <td class="adm-actions">
                            <a class="adm-link" href="{{ route('admin.resource.edit', [$resource, $row->id]) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.resource.destroy', [$resource, $row->id]) }}"
                                  onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="adm-link danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
