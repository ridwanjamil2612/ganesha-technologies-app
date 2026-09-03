<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:150',
            'instansi' => 'nullable|string|max:150',
            'phone'    => 'required|string|max:40',
            'email'    => 'nullable|email|max:150',
            'message'  => 'required|string|max:3000',
        ], [], [
            'name' => 'Nama Lengkap',
            'phone' => 'No HP',
            'message' => 'Kebutuhan Spesifik',
        ]);

        $contact = Contact::create($data);

        // Simpan tersimpan + arahkan ke WhatsApp dengan pesan sudah terisi
        return redirect()->away($contact->waLink());
    }
}
