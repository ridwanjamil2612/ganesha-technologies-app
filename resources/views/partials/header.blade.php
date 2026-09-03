<header class="site-header">
    <nav class="nav" aria-label="Navigasi utama">
        <a href="{{ route('home') }}" class="brand">
            <img src="{{ asset('img/Logo2.png') }}" alt="" style="">
            <span>Ganesha 
                <small>Technologies</small>
            </span>
        </a>

        <ul class="nav-links" id="navmenu">
            @foreach (config('ganesha.nav') as $item)
                <li>
                    <a href="{{ route($item['route']) }}"
                       class="{{ request()->routeIs($item['route']) || request()->routeIs($item['route'].'.*') ? 'active' : '' }}">
                        {{ \Illuminate\Support\Facades\Lang::has('site.nav_'.$item['route']) ? __('site.nav_'.$item['route']) : $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="nav-cta">
            <div class="lang-switch" role="group" aria-label="Pilih bahasa">
                <a href="{{ route('lang', 'id') }}" class="{{ app()->getLocale() === 'id' ? 'on' : '' }}">ID</a>
                <a href="{{ route('lang', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'on' : '' }}">EN</a>
            </div>
            <a class="btn btn--green" href="https://wa.me/{{ config('ganesha.company.whatsapp') }}" target="_blank" rel="noopener">{{ __('site.cta_penawaran') }}</a>
            <button class="nav-toggle" aria-label="Buka menu" aria-controls="navmenu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>
</header>
