@extends('admin.layout')
@section('title', 'Dashboard')

@php
    $palette = ['#5A8F27','#8BC34A','#3CC0E4','#2E7CC4','#8A5CD0','#C98A1E','#C1492F','#2AA7A0'];

    // ---- geometri grafik garis (kunjungan 14 hari) ----
    $W=760;$H=240;$padL=16;$padR=16;$padT=18;$padB=32;
    $plotW=$W-$padL-$padR;$plotH=$H-$padT-$padB;
    $vals=array_map(fn($s)=>$s['count'],$series);
    $vmax=max(1,max($vals));
    $n=count($series);
    $pts=[];
    foreach($series as $i=>$s){
        $x=$padL+($n>1?$i*($plotW/($n-1)):0);
        $y=$padT+$plotH*(1-$s['count']/$vmax);
        $pts[]=[round($x,1),round($y,1)];
    }
    $line=implode(' ',array_map(fn($p)=>$p[0].','.$p[1],$pts));
    $baseY=$padT+$plotH;
    $area='M '.$pts[0][0].','.$baseY.' L '.implode(' L ',array_map(fn($p)=>$p[0].','.$p[1],$pts)).' L '.$pts[$n-1][0].','.$baseY.' Z';

    $sectorTotal=$bySector->sum('c');
@endphp

@section('content')
    <div class="adm-hero">
        <div>
            <h1>Halo, {{ auth()->user()->name ?? 'Admin' }} 👋</h1>
            <p>Ringkasan situs & konten Ganesha Flame.</p>
        </div>
        <div class="adm-hero-actions">
            <a class="adm-btn" href="{{ route('admin.resource.create','products') }}"><span class="adm-nav-ico">@include('admin.icon',['name'=>'plus'])</span> Produk</a>
            <a class="adm-btn" href="{{ route('admin.resource.create','news') }}"><span class="adm-nav-ico">@include('admin.icon',['name'=>'plus'])</span> Berita</a>
            <a class="adm-btn" href="{{ route('admin.resource.create','projects') }}"><span class="adm-nav-ico">@include('admin.icon',['name'=>'plus'])</span> Proyek</a>
        </div>
    </div>

    <div class="kpi-row">
        <div class="kpi">
            <span class="kpi-ico i-stats">@include('admin.icon',['name'=>'stats'])</span>
            <div><span class="kpi-num">{{ number_format($visitsToday) }}</span><span class="kpi-sub">Kunjungan hari ini</span></div>
        </div>
        <div class="kpi">
            <span class="kpi-ico i-news">@include('admin.icon',['name'=>'dashboard'])</span>
            <div><span class="kpi-num">{{ number_format($visits30) }}</span><span class="kpi-sub">Kunjungan 30 hari</span></div>
        </div>
        <div class="kpi">
            <span class="kpi-ico i-faqs">@include('admin.icon',['name'=>'site'])</span>
            <div><span class="kpi-num">{{ number_format($visitsTotal) }}</span><span class="kpi-sub">Total halaman dilihat</span></div>
        </div>
        <div class="kpi">
            <span class="kpi-ico">@include('admin.icon',['name'=>'products'])</span>
            <div><span class="kpi-num">{{ $counts['products']['count'] ?? 0 }}</span><span class="kpi-sub">Produk terdaftar</span></div>
        </div>
    </div>

    <div class="dash-grid">
        {{-- Ringkasan SEO --}}
        @php $seoRing = $seo['overall']>=80?'#5A8F27':($seo['overall']>=50?'#C98A1E':'#C1492F'); @endphp
        <div class="panel col-12 seo-summary">
            <svg viewBox="0 0 42 42" class="seo-ring">
                <circle cx="21" cy="21" r="15.9155" fill="none" stroke="#EEF2E6" stroke-width="4"/>
                <circle cx="21" cy="21" r="15.9155" fill="none" stroke="{{ $seoRing }}" stroke-width="4"
                        stroke-dasharray="{{ $seo['overall'] }} {{ 100-$seo['overall'] }}" stroke-dashoffset="25" stroke-linecap="round"/>
                <text x="21" y="21.5" text-anchor="middle" font-size="10" font-weight="800" fill="#1C2718">{{ $seo['overall'] }}</text>
            </svg>
            <div class="seo-sum-meta">
                <h3>Skor SEO konten</h3>
                <p>{{ $seo['ok'] }} bagus · {{ $seo['warn'] }} sedang · {{ $seo['bad'] }} kurang — dari {{ $seo['total'] }} konten</p>
                <div class="seo-tally">
                    @php $lm=['image'=>'tanpa gambar','title'=>'judul','desc'=>'deskripsi','content'=>'isi pendek','slug'=>'slug']; @endphp
                    @foreach ($seo['tally'] as $k=>$c)
                        @if ($c>0)<span class="chip warn">{{ $c }} {{ $lm[$k] ?? $k }}</span>@endif
                    @endforeach
                    @if (collect($seo['tally'])->sum()===0)<span class="chip ok">Semua konten sehat 🎉</span>@endif
                </div>
            </div>
            <a class="adm-btn adm-btn-primary" href="{{ route('admin.seo') }}">Lihat audit lengkap →</a>
        </div>

        {{-- Grafik kunjungan --}}
        <div class="panel col-8">
            <div class="panel-head"><h3>Kunjungan 14 hari terakhir</h3></div>
            @if ($visitsTotal === 0)
                <div class="panel-empty">Belum ada data kunjungan. Data muncul otomatis saat halaman publik dibuka.</div>
            @else
                <svg class="chart-line" viewBox="0 0 {{ $W }} {{ $H }}" preserveAspectRatio="none" role="img">
                    <defs><linearGradient id="areaFill" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0" stop-color="#8BC34A" stop-opacity=".35"/>
                        <stop offset="1" stop-color="#8BC34A" stop-opacity="0"/>
                    </linearGradient></defs>
                    @for ($g=0;$g<=3;$g++)
                        @php $gy=$padT+$plotH*$g/3; @endphp
                        <line x1="{{ $padL }}" y1="{{ $gy }}" x2="{{ $W-$padR }}" y2="{{ $gy }}" stroke="#EBF1E1" stroke-width="1"/>
                    @endfor
                    <path d="{{ $area }}" fill="url(#areaFill)"/>
                    <polyline points="{{ $line }}" fill="none" stroke="#5A8F27" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round"/>
                    @foreach ($pts as $i=>$p)
                        <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="3" fill="#fff" stroke="#5A8F27" stroke-width="2"/>
                        @if ($i % 2 === 0)
                            <text x="{{ $p[0] }}" y="{{ $H-10 }}" text-anchor="middle" font-size="11" fill="#8A9A78">{{ $series[$i]['label'] }}</text>
                        @endif
                    @endforeach
                </svg>
            @endif
        </div>

        {{-- Donut sektor --}}
        <div class="panel col-4">
            <div class="panel-head"><h3>Proyek per sektor</h3></div>
            @if ($sectorTotal === 0)
                <div class="panel-empty">Belum ada data proyek.</div>
            @else
                <div class="donut-wrap">
                    <svg viewBox="0 0 42 42" class="donut">
                        <circle cx="21" cy="21" r="15.9155" fill="none" stroke="#EEF2E6" stroke-width="5"/>
                        @php $acc=0; @endphp
                        @foreach ($bySector as $i=>$row)
                            @php $pct=round($row->c/$sectorTotal*100,2); $off=25-$acc; $acc+=$pct; @endphp
                            <circle cx="21" cy="21" r="15.9155" fill="none" stroke="{{ $palette[$i % count($palette)] }}"
                                    stroke-width="5" stroke-dasharray="{{ $pct }} {{ 100-$pct }}" stroke-dashoffset="{{ $off }}"/>
                        @endforeach
                        <text x="21" y="20.5" text-anchor="middle" font-size="7" font-weight="700" fill="#1C2718">{{ $sectorTotal }}</text>
                        <text x="21" y="25.5" text-anchor="middle" font-size="3" fill="#8A9A78">PROYEK</text>
                    </svg>
                    <ul class="legend">
                        @foreach ($bySector as $i=>$row)
                            <li><span class="dot" style="background:{{ $palette[$i % count($palette)] }}"></span>{{ $row->k }} <b>{{ $row->c }}</b></li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- Produk per segmen --}}
        <div class="panel col-4">
            <div class="panel-head"><h3>Produk per segmen</h3></div>
            @if ($bySegment->isEmpty())
                <div class="panel-empty">Belum ada produk.</div>
            @else
                @php $segMax=max(1,$bySegment->max('c')); @endphp
                <div class="hbars">
                    @foreach ($bySegment as $i=>$row)
                        <div class="hbar">
                            <span class="hbar-label">{{ $row->k }}</span>
                            <span class="hbar-track"><span class="hbar-fill" style="width:{{ round($row->c/$segMax*100) }}%;background:{{ $palette[$i % count($palette)] }}"></span></span>
                            <span class="hbar-val">{{ $row->c }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Halaman terpopuler --}}
        <div class="panel col-4">
            <div class="panel-head"><h3>Halaman terpopuler <small>30 hari</small></h3></div>
            @if ($topPages->isEmpty())
                <div class="panel-empty">Belum ada data.</div>
            @else
                @php $pMax=max(1,$topPages->max('c')); @endphp
                <div class="hbars">
                    @foreach ($topPages as $row)
                        <div class="hbar">
                            <span class="hbar-label mono">{{ $row->path }}</span>
                            <span class="hbar-track"><span class="hbar-fill" style="width:{{ round($row->c/$pMax*100) }}%"></span></span>
                            <span class="hbar-val">{{ $row->c }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Kelengkapan gambar --}}
        <div class="panel col-4">
            <div class="panel-head"><h3>Kelengkapan gambar</h3></div>
            <div class="prog">
                <div class="prog-label">Produk <span>{{ $completeness['products']['part'] }}/{{ $completeness['products']['total'] }}</span></div>
                <div class="prog-track"><span style="width:{{ $completeness['products']['pct'] }}%"></span></div>
            </div>
            <div class="prog">
                <div class="prog-label">Berita <span>{{ $completeness['news']['part'] }}/{{ $completeness['news']['total'] }}</span></div>
                <div class="prog-track"><span style="width:{{ $completeness['news']['pct'] }}%"></span></div>
            </div>
            <div class="mini-inv">
                @foreach ($counts as $key=>$c)
                    <a class="inv-chip" href="{{ route('admin.resource.index',$key) }}"><b>{{ $c['count'] }}</b> {{ $c['label'] }}</a>
                @endforeach
            </div>
        </div>

        {{-- Berita terbaru --}}
        <div class="panel col-6">
            <div class="panel-head"><h3>Berita terbaru</h3><a class="panel-link" href="{{ route('admin.resource.index','news') }}">Kelola →</a></div>
            @forelse ($recentNews as $nw)
                <a class="list-row" href="{{ route('admin.resource.edit',['news',$nw->id]) }}">
                    <span class="list-ico i-news">@include('admin.icon',['name'=>'news'])</span>
                    <span class="list-main"><b>{{ \Illuminate\Support\Str::limit($nw->title,50) }}</b>
                        <small>{{ $nw->category }} · {{ optional($nw->date)->translatedFormat('d M Y') }}</small></span>
                </a>
            @empty
                <div class="panel-empty">Belum ada berita.</div>
            @endforelse
        </div>

        {{-- Proyek terbaru --}}
        <div class="panel col-6">
            <div class="panel-head"><h3>Proyek terbaru</h3><a class="panel-link" href="{{ route('admin.resource.index','projects') }}">Kelola →</a></div>
            @forelse ($recentProjects as $pr)
                <a class="list-row" href="{{ route('admin.resource.edit',['projects',$pr->id]) }}">
                    <span class="list-ico i-projects">@include('admin.icon',['name'=>'projects'])</span>
                    <span class="list-main"><b>{{ \Illuminate\Support\Str::limit($pr->client,46) }}</b>
                        <small>{{ $pr->sector }}{{ $pr->year ? ' · '.$pr->year : '' }}</small></span>
                </a>
            @empty
                <div class="panel-empty">Belum ada proyek.</div>
            @endforelse
        </div>
    </div>
@endsection
