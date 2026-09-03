@extends('admin.layout')
@section('title', 'Audit SEO')

@php
    $ring = $a['overall'] >= 80 ? '#5A8F27' : ($a['overall'] >= 50 ? '#C98A1E' : '#C1492F');
    $rating = $a['overall'] >= 80 ? 'Baik' : ($a['overall'] >= 50 ? 'Perlu perbaikan' : 'Kurang');
    $labelMap = ['image'=>'tanpa gambar','title'=>'judul bermasalah','desc'=>'deskripsi bermasalah','content'=>'isi terlalu pendek','slug'=>'slug kosong'];
@endphp

@section('content')
    <div class="adm-toolbar">
        <h1>Audit SEO</h1>
    </div>

    <div class="dash-grid">
        {{-- Skor --}}
        <div class="panel col-4">
            <div class="panel-head"><h3>Skor SEO konten</h3></div>
            <div class="seo-score">
                <svg viewBox="0 0 42 42" class="seo-ring">
                    <circle cx="21" cy="21" r="15.9155" fill="none" stroke="#EEF2E6" stroke-width="4"/>
                    <circle cx="21" cy="21" r="15.9155" fill="none" stroke="{{ $ring }}" stroke-width="4"
                            stroke-dasharray="{{ $a['overall'] }} {{ 100-$a['overall'] }}" stroke-dashoffset="25" stroke-linecap="round"/>
                    <text x="21" y="20.5" text-anchor="middle" font-size="9" font-weight="800" fill="#1C2718">{{ $a['overall'] }}</text>
                    <text x="21" y="26" text-anchor="middle" font-size="3.4" fill="#8A9A78">/ 100</text>
                </svg>
                <div class="seo-score-meta">
                    <span class="badge" style="background:{{ $ring }}1a;color:{{ $ring }}">{{ $rating }}</span>
                    <p>{{ $a['ok'] }} bagus · {{ $a['warn'] }} sedang · {{ $a['bad'] }} kurang<br><small>dari {{ $a['total'] }} konten</small></p>
                </div>
            </div>
            <div class="seo-tally">
                @foreach ($a['tally'] as $key => $count)
                    @if ($count > 0)
                        <span class="chip warn">{{ $count }} {{ $labelMap[$key] ?? $key }}</span>
                    @endif
                @endforeach
                @if (collect($a['tally'])->sum() === 0)
                    <span class="chip ok">Semua konten sehat 🎉</span>
                @endif
            </div>
        </div>

        {{-- Teknis --}}
        <div class="panel col-8">
            <div class="panel-head"><h3>SEO Teknis</h3></div>
            <ul class="seo-check">
                @foreach ($a['technical'] as $t)
                    <li class="{{ $t['ok'] ? 'yes' : 'no' }}">
                        <span class="ck">@if($t['ok'])✓@else!@endif</span> {{ $t['label'] }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Daftar perbaikan --}}
    <div class="panel">
        <div class="panel-head"><h3>Konten yang perlu diperbaiki</h3></div>
        @if (empty($a['needWork']))
            <div class="panel-empty">Bagus! Semua konten sudah memenuhi kriteria SEO dasar.</div>
        @else
            <div class="adm-tablewrap" style="box-shadow:none;border:none">
                <table class="adm-table">
                    <thead><tr><th>Konten</th><th>Skor</th><th>Yang perlu diperbaiki</th><th class="adm-actions-h">Aksi</th></tr></thead>
                    <tbody>
                    @foreach ($a['needWork'] as $it)
                        @php $c = $it['score'] >= 80 ? '#5A8F27' : ($it['score'] >= 50 ? '#C98A1E' : '#C1492F'); @endphp
                        <tr>
                            <td><small style="color:var(--muted)">{{ $it['type'] }}</small><br><b>{{ \Illuminate\Support\Str::limit($it['title'],48) }}</b></td>
                            <td><span class="score-pill" style="background:{{ $c }}1a;color:{{ $c }}">{{ $it['score'] }}</span></td>
                            <td><ul class="prob">@foreach ($it['problems'] as $pr)<li>{{ $pr }}</li>@endforeach</ul></td>
                            <td class="adm-actions"><a class="adm-link" href="{{ $it['editUrl'] }}">Perbaiki</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
