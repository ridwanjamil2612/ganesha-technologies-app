<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Brochure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrochureController extends Controller
{
    public function index()
    {
        $brochures = Brochure::orderBy('sort')->orderBy('id')->get();

        return view('admin.brochures.index', compact('brochures'));
    }

    public function create()
    {
        $brochure = new Brochure;

        return view('admin.brochures.form', compact('brochure'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'sort'  => 'nullable|integer',
            'file'  => 'required|file|mimes:pdf|max:10240',
            'thumb' => 'nullable|image|max:3072',
        ]);

        $b = new Brochure;
        $b->title = $data['title'];
        $b->sort = $data['sort'] ?? 0;
        $b->file = $request->file('file')->store('brochures', 'public');
        if ($request->hasFile('thumb')) {
            $b->thumb = $request->file('thumb')->store('brochures/thumb', 'public');
        }
        $b->save();

        AuditLog::record('create', 'Brosur', 'Menambah brosur: ' . $b->title);

        return redirect()->route('admin.brochures.index')->with('ok', 'Brosur berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $brochure = Brochure::findOrFail($id);

        return view('admin.brochures.form', compact('brochure'));
    }

    public function update(Request $request, $id)
    {
        $b = Brochure::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:150',
            'sort'  => 'nullable|integer',
            'file'  => 'nullable|file|mimes:pdf|max:10240',
            'thumb' => 'nullable|image|max:3072',
        ]);

        $b->title = $data['title'];
        $b->sort = $data['sort'] ?? 0;
        if ($request->hasFile('file')) {
            if ($b->file) {
                Storage::disk('public')->delete($b->file);
            }
            $b->file = $request->file('file')->store('brochures', 'public');
        }
        if ($request->boolean('thumb_delete') && $b->thumb) {
            Storage::disk('public')->delete($b->thumb);
            $b->thumb = null;
        }
        if ($request->hasFile('thumb')) {
            if ($b->thumb) {
                Storage::disk('public')->delete($b->thumb);
            }
            $b->thumb = $request->file('thumb')->store('brochures/thumb', 'public');
        }
        $b->save();

        AuditLog::record('update', 'Brosur', 'Mengubah brosur: ' . $b->title);

        return redirect()->route('admin.brochures.index')->with('ok', 'Brosur berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $b = Brochure::findOrFail($id);
        if ($b->file) {
            Storage::disk('public')->delete($b->file);
        }
        if ($b->thumb) {
            Storage::disk('public')->delete($b->thumb);
        }
        $title = $b->title;
        $b->delete();

        AuditLog::record('delete', 'Brosur', 'Menghapus brosur: ' . $title);

        return redirect()->route('admin.brochures.index')->with('ok', 'Brosur berhasil dihapus.');
    }
}
