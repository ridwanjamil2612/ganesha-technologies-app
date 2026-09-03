<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') — {{ config('ganesha.company.short', 'Ganesha Flame') }}</title>
    <link rel="icon" href="{{ asset('img/Logo2.png') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="adm">
    <input type="checkbox" id="navtoggle" hidden>
    <label for="navtoggle" class="adm-overlay"></label>

    <aside class="adm-side">
        <div class="adm-brand">
            <img src="{{ asset('img/logo2.png') }}" alt="" width="28" height="28">
            <span>Ganesha Technologies<small>Panel Admin</small></span>
        </div>

        <nav class="adm-nav">
            @php $can = fn ($p) => \App\Support\Perms::allows(auth()->user(), $p); @endphp

            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'on' : '' }}">
                <span class="adm-nav-ico">@include('admin.icon', ['name' => 'dashboard'])</span> Dashboard
            </a>

            @if ($can('messages.view'))
                @php
                    try { $unreadMsg = \Illuminate\Support\Facades\Schema::hasTable('contacts') ? \App\Models\Contact::where('is_read', false)->count() : 0; }
                    catch (\Throwable $e) { $unreadMsg = 0; }
                @endphp
                <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'on' : '' }}">
                    <span class="adm-nav-ico">@include('admin.icon', ['name' => 'inbox'])</span> Pesan Masuk
                    @if ($unreadMsg > 0)<span class="nav-badge">{{ $unreadMsg }}</span>@endif
                </a>
            @endif

            @php $contentDefs = \App\Admin\Resources::all(); @endphp
            @if (collect($contentDefs)->keys()->contains(fn ($k) => $can('content.' . $k)))
                <p class="adm-navlabel">Konten</p>
                @foreach ($contentDefs as $key => $def)
                    @if ($can('content.' . $key))
                        <a href="{{ route('admin.resource.index', $key) }}"
                           class="{{ request()->routeIs('admin.resource.*') && request()->route('resource') === $key ? 'on' : '' }}">
                            <span class="adm-nav-ico">@include('admin.icon', ['name' => $key])</span> {{ $def['label'] }}
                        </a>
                    @endif
                @endforeach
            @endif

            <p class="adm-navlabel">Situs</p>
            @if ($can('seo'))
                <a href="{{ route('admin.seo') }}" class="{{ request()->routeIs('admin.seo') ? 'on' : '' }}">
                    <span class="adm-nav-ico">@include('admin.icon', ['name' => 'seo'])</span> Audit SEO
                </a>
            @endif
            @if ($can('brochures'))
                <a href="{{ route('admin.brochures.index') }}" class="{{ request()->routeIs('admin.brochures.*') ? 'on' : '' }}">
                    <span class="adm-nav-ico">@include('admin.icon', ['name' => 'brochures'])</span> Brosur
                </a>
            @endif
            @if ($can('users'))
                <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'on' : '' }}">
                    <span class="adm-nav-ico">@include('admin.icon', ['name' => 'roles'])</span> Peran &amp; Akses
                </a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'on' : '' }}">
                    <span class="adm-nav-ico">@include('admin.icon', ['name' => 'users'])</span> Kelola User
                </a>
            @endif
            @if ($can('settings'))
                <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.*') ? 'on' : '' }}">
                    <span class="adm-nav-ico">@include('admin.icon', ['name' => 'settings'])</span> Pengaturan
                </a>
            @endif
            @if ($can('audit'))
                <a href="{{ route('admin.audit.index') }}" class="{{ request()->routeIs('admin.audit.*') ? 'on' : '' }}">
                    <span class="adm-nav-ico">@include('admin.icon', ['name' => 'audit'])</span> Log Aktivitas
                </a>
            @endif
            <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.*') ? 'on' : '' }}">
                <span class="adm-nav-ico">@include('admin.icon', ['name' => 'profile'])</span> Akun
            </a>
            <a href="{{ route('home') }}" target="_blank" rel="noopener">
                <span class="adm-nav-ico">@include('admin.icon', ['name' => 'site'])</span> Lihat Situs
            </a>
            <a href="{{ route('admin.help') }}" class="{{ request()->routeIs('admin.help') ? 'on' : '' }}">
                <span class="adm-nav-ico">@include('admin.icon', ['name' => 'help'])</span> Panduan
            </a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="adm-logout">
            @csrf
            <button type="submit">
                <span class="adm-nav-ico">@include('admin.icon', ['name' => 'logout'])</span> Keluar
            </button>
        </form>
    </aside>

    <main class="adm-main">
        <header class="adm-top">
            <label for="navtoggle" class="adm-burger" aria-label="Menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" width="22" height="22"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </label>
            <div class="adm-top-title">@yield('title', 'Admin')</div>
            <div class="adm-user">
                <span class="adm-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                <span class="adm-user-name">{{ auth()->user()->name ?? '' }}</span>
            </div>
        </header>

        <div class="adm-body">
            @if (session('ok'))
                <div class="adm-flash ok">{{ session('ok') }}</div>
            @endif
            @if ($errors->any())
                <div class="adm-flash err">
                    Periksa kembali isian berikut:
                    <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
