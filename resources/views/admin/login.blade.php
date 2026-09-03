<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Masuk Admin — {{ config('ganesha.company.short', 'Ganesha Flame') }}</title>
    <link rel="icon" href="{{ asset('img/Logo2.png') }}" type="logo">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="adm-login-page">
    <form class="adm-login" method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <div class="adm-login-brand">
            <img src="{{ asset('img/Logo2.png') }}" alt="" width="54" height="54">
            <strong>{{ config('ganesha.company.short', 'Ganesha Flame') }}</strong>
            <span>Panel Admin</span>
        </div>
        @if ($errors->any())
            <div class="adm-flash err">{{ $errors->first() }}</div>
        @endif
        <label>Email
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </label>
        <label>Kata sandi
            <span class="pw-wrap">
                <input id="pw" type="password" name="password" required>
                <button type="button" class="pw-toggle" aria-label="Tampilkan kata sandi" aria-pressed="false"
                        onclick="(function(b){var i=document.getElementById('pw');var s=i.type==='password';i.type=s?'text':'password';b.setAttribute('aria-pressed',s);b.setAttribute('aria-label',s?'Sembunyikan kata sandi':'Tampilkan kata sandi');b.classList.toggle('on',s);})(this)">
                    <svg class="ic-eye" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12z"/><circle cx="12" cy="12" r="3.2"/></svg>
                    <svg class="ic-eye-off" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l18 18"/><path d="M10.6 6.2A9.7 9.7 0 0 1 12 6c7 0 10.5 6 10.5 6a17 17 0 0 1-3.4 4.1"/><path d="M6.5 7.6A16.6 16.6 0 0 0 1.5 12S5 18 12 18a10 10 0 0 0 3.4-.6"/><path d="M9.5 9.6a3.2 3.2 0 0 0 4.5 4.5"/></svg>
                </button>
            </span>
        </label>
        <label class="adm-check">
            <input type="checkbox" name="remember" value="1"> Ingat saya
        </label>
        <button type="submit" class="adm-btn adm-btn-primary">Masuk</button>
    </form>
</body>
</html>
