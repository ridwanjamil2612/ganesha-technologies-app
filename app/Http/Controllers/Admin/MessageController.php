<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Contact::orderByDesc('created_at')->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    public function show($id)
    {
        $message = Contact::findOrFail($id);
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function export()
    {
        $rows = Contact::orderByDesc('created_at')->get();
        $filename = 'pesan-masuk-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'no-store, no-cache',
        ];

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            // BOM UTF-8 agar huruf & tanda baca Indonesia tampil benar di Excel
            fwrite($out, "\xEF\xBB\xBF");
            // pemisah titik-koma (;) agar otomatis terbagi kolom di Excel Indonesia
            fputcsv($out, ['Tanggal', 'Nama', 'Instansi', 'No HP', 'Email', 'Kebutuhan/Pesan', 'Status'], ';');
            foreach ($rows as $m) {
                fputcsv($out, [
                    optional($m->created_at)->format('Y-m-d H:i'),
                    $m->name,
                    $m->instansi,
                    $m->phone,
                    $m->email,
                    $m->message ?? $m->kebutuhan ?? $m->need ?? $m->pesan ?? '',
                    $m->is_read ? 'Sudah dibaca' : 'Belum dibaca',
                ], ';');
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('ok', 'Pesan berhasil dihapus.');
    }
}
