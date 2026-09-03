<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::firstOrNew([]);

        return view('admin.settings', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'       => 'nullable|string|max:150',
            'short'      => 'nullable|string|max:80',
            'tagline'    => 'nullable|string',
            'tagline_en' => 'nullable|string',
            'desc'       => 'nullable|string',
            'desc_en'    => 'nullable|string',
            'email'      => 'nullable|email|max:150',
            'phone'      => 'nullable|string|max:50',
            'whatsapp'   => 'nullable|string|max:30',
            'address'    => 'nullable|string',
            'hours'      => 'nullable|string|max:150',
            'founded'    => 'nullable|integer|min:1900|max:2100',
            'video_url'  => 'nullable|string|max:255',
        ]);

        $setting = Setting::firstOrNew([]);
        $setting->fill($data)->save();

        return redirect()
            ->route('admin.settings.edit')
            ->with('ok', 'Pengaturan perusahaan berhasil disimpan.');
    }
}
