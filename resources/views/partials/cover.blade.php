@php
    // Cover geometris brand: 4x4 quarter-circle dari seed string (deterministik).
    $seed = $seed ?? 'gf';
    $h = crc32($seed);
    $cols = ['#2460A8', '#90C048', '#3CC0E4'];
    $corners = ['tl', 'tr', 'br', 'bl'];
    $bg = $bg ?? '#0E2747';
    $n = 4; $s = 100; $w = $n * $s;

    $cellPath = function ($cx, $cy, $corner) use ($s) {
        $x0 = $cx * $s; $y0 = $cy * $s;
        return match ($corner) {
            'tl' => "M{$x0},{$y0} L" . ($x0 + $s) . ",{$y0} A{$s},{$s} 0 0 1 {$x0}," . ($y0 + $s) . " Z",
            'tr' => "M" . ($x0 + $s) . ",{$y0} L" . ($x0 + $s) . "," . ($y0 + $s) . " A{$s},{$s} 0 0 1 {$x0},{$y0} Z",
            'br' => "M" . ($x0 + $s) . "," . ($y0 + $s) . " L{$x0}," . ($y0 + $s) . " A{$s},{$s} 0 0 1 " . ($x0 + $s) . ",{$y0} Z",
            'bl' => "M{$x0}," . ($y0 + $s) . " L{$x0},{$y0} A{$s},{$s} 0 0 1 " . ($x0 + $s) . "," . ($y0 + $s) . " Z",
        };
    };
@endphp
<svg viewBox="0 0 {{ $w }} {{ $w }}" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi">
    <rect width="{{ $w }}" height="{{ $w }}" fill="{{ $bg }}"/>
    @for ($i = 0; $i < $n; $i++)
        @for ($j = 0; $j < $n; $j++)
            @php
                $bit = ($h >> (($i * $n + $j) % 31)) & 1;
                $bit2 = ($h >> (($i * $n + $j + 7) % 31)) & 1;
            @endphp
            @if ($bit || (($i + $j) % 3 === 0))
                <path d="{{ $cellPath($j, $i, $corners[($h >> ($i + $j)) % 4]) }}"
                      fill="{{ $cols[($h >> (($i + $j) % 11)) % 3] }}"
                      opacity="{{ $bit2 ? '1' : '.92' }}"/>
            @endif
        @endfor
    @endfor
</svg>
