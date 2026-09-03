<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    protected $casts = ['is_read' => 'boolean'];

    public function waLink(): string
    {
        $lines = [
            'Halo, saya menghubungi via website.',
            '',
            'Nama: ' . $this->name,
            'Instansi: ' . ($this->instansi ?: '-'),
            'No HP: ' . $this->phone,
        ];
        if ($this->email) {
            $lines[] = 'Email: ' . $this->email;
        }
        $lines[] = '';
        $lines[] = 'Kebutuhan:';
        $lines[] = $this->message;

        return 'https://wa.me/' . preg_replace('/\D+/', '', (string) config('ganesha.company.whatsapp'))
            . '?text=' . rawurlencode(implode("\n", $lines));
    }

    public function customerWaLink(): string
    {
        $wa = preg_replace('/\D+/', '', (string) $this->phone);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        } elseif (str_starts_with($wa, '8')) {
            $wa = '62' . $wa;
        }
        $text = 'Halo ' . $this->name . ', terima kasih telah menghubungi '
            . config('ganesha.company.name') . '.';

        return 'https://wa.me/' . $wa . '?text=' . rawurlencode($text);
    }
}
