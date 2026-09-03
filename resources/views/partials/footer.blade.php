@php $c = config('ganesha.company'); @endphp

{{-- CTA band --}}
<section class="cta-band" id="kontak">
    <img class="deco" src="{{ asset('img/tile-pinwheel.svg') }}" alt="">
    <div class="wrap">
        <h2>{{ __('site.form_judul') }}</h2>
        <p class="cta-sub">{{ __('site.form_sub') }}</p>

        @if ($errors->any())
            <div class="kontak-err">{{ __('site.form_error') }}
                <ul style="margin:.3rem 0 0;padding-left:1.1rem">
                    @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form class="kontak-form" method="POST" action="{{ route('kontak.store') }}">
            @csrf
            <div class="kontak-grid">
                <label>{{ __('site.form_nama') }}*
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </label>
                <label>{{ __('site.form_instansi') }}
                    <input type="text" name="instansi" value="{{ old('instansi') }}">
                </label>
                <label>{{ __('site.form_hp') }}*
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                </label>
                <label>{{ __('site.form_email') }}
                    <input type="email" name="email" value="{{ old('email') }}">
                </label>
            </div>
            <label class="kontak-full">{{ __('site.form_kebutuhan') }}*
                <textarea name="message" rows="4" placeholder="{{ __('site.form_msg_ph') }}" required>{{ old('message') }}</textarea>
            </label>
            <button type="submit" class="btn btn--wa">{{ __('site.form_kirim') }}</button>
        </form>
    </div>
</section>

<footer class="site-footer">
    <div class="wrap">
        <div class="footer-grid">
            <div class="footer-about">
                <div class="footer-brand">
                    <img src="{{ asset('img/Logo2.png') }}" alt="">
                    Ganesha Tehnologies
                </div>
                <p>{{ $c['desc'] }}</p>
            </div>

            <div>
                <h4>{{ __('site.jelajahi') }}</h4>
                @foreach (config('ganesha.nav') as $item)
                    <a href="{{ route($item['route']) }}">{{ \Illuminate\Support\Facades\Lang::has('site.nav_'.$item['route']) ? __('site.nav_'.$item['route']) : $item['label'] }}</a>
                @endforeach
            </div>

            <div>
                <h4>{{ __('site.kontak') }}</h4>
                <a href="mailto:{{ $c['email'] }}">{{ $c['email'] }}</a>
                <a href="https://wa.me/{{ $c['whatsapp'] }}" target="_blank" rel="noopener">{{ $c['phone'] }}</a>
                <p style="margin-top:.6rem; color:#9FB6D2; font-size:.9rem">{{ $c['address'] }}</p>
                <p style="margin-top:.4rem; color:#7C93B3; font-size:.85rem">{{ $c['hours'] }}</p>
            </div>
        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} {{ $c['name'] }}. {{ __('site.hak_cipta') }}</span>
            <span>{{ __('site.sejak') }} {{ $c['founded'] }} · </span>
        </div>
    </div>
</footer>
