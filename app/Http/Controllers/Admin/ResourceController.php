<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Resources;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    private function def(string $resource): array
    {
        $def = Resources::find($resource);
        abort_if($def === null, 404);
        return $def;
    }

    private function label($def, $item): string
    {
        return (string) ($item->title ?? $item->name ?? $item->code ?? ('#' . $item->id));
    }

    public function index(string $resource)
    {
        $def = $this->def($resource);
        $model = $def['model'];
        $rows = $model::ordered()->get();

        return view('admin.resource.index', compact('def', 'rows', 'resource'));
    }

    public function create(string $resource)
    {
        $def = $this->def($resource);
        $item = new $def['model'];

        return view('admin.resource.form', compact('def', 'item', 'resource'));
    }

    public function store(string $resource, Request $request)
    {
        $def = $this->def($resource);
        $data = $this->validated($def, $request);
        $data = $this->transform($def, $data, $request, null);

        $model = $def['model'];
        $data['sort'] = ($model::max('sort') ?? -1) + 1;
        $item = $model::create($data);

        AuditLog::record('create', $def['singular'], 'Menambah ' . $def['singular'] . ': ' . $this->label($def, $item));

        return redirect()
            ->route('admin.resource.index', $resource)
            ->with('ok', $def['singular'] . ' berhasil ditambahkan.');
    }

    public function edit(string $resource, $id)
    {
        $def = $this->def($resource);
        $item = $def['model']::findOrFail($id);

        return view('admin.resource.form', compact('def', 'item', 'resource'));
    }

    public function update(string $resource, $id, Request $request)
    {
        $def = $this->def($resource);
        $item = $def['model']::findOrFail($id);

        $data = $this->validated($def, $request, $id);
        $data = $this->transform($def, $data, $request, $item);
        $item->update($data);

        AuditLog::record('update', $def['singular'], 'Mengubah ' . $def['singular'] . ': ' . $this->label($def, $item));

        return redirect()
            ->route('admin.resource.index', $resource)
            ->with('ok', $def['singular'] . ' berhasil diperbarui.');
    }

    public function destroy(string $resource, $id)
    {
        $def = $this->def($resource);
        $item = $def['model']::findOrFail($id);
        $label = $this->label($def, $item);
        $item->delete();

        AuditLog::record('delete', $def['singular'], 'Menghapus ' . $def['singular'] . ': ' . $label);

        return redirect()
            ->route('admin.resource.index', $resource)
            ->with('ok', $def['singular'] . ' berhasil dihapus.');
    }

    // ----- helpers -----

    private function validated(array $def, Request $request, $id = null): array
    {
        $rules = [];
        foreach ($def['fields'] as $f) {
            if (($f['type'] ?? '') === 'images') {
                $rules[$f['name'] . '.*'] = 'nullable|image|max:3072';
            } else {
                $rules[$f['name']] = $f['rules'] ?? 'nullable';
            }
        }
        return $request->validate($rules);
    }

    private function transform(array $def, array $data, Request $request, $item = null): array
    {
        foreach ($def['fields'] as $f) {
            $name = $f['name'];
            $type = $f['type'] ?? 'text';

            if ($type === 'kvlines') {
                $data[$name] = $this->parseKv($request->input($name, ''));
            } elseif ($type === 'paragraphs') {
                $data[$name] = $this->parseParagraphs($request->input($name, ''));
            } elseif ($type === 'image') {
                if ($request->hasFile($name)) {
                    $data[$name] = $request->file($name)->store($def['key'], 'public');
                } else {
                    unset($data[$name]); // tidak ada unggahan baru -> pertahankan gambar lama
                }
            } elseif ($type === 'images') {
                $keep = ($item && is_array($item->{$name})) ? array_values($item->{$name}) : [];

                // hapus gambar yang dicentang
                $toDelete = (array) $request->input($name . '_delete', []);
                if ($toDelete) {
                    foreach ($toDelete as $path) {
                        Storage::disk('public')->delete($path);
                    }
                    $keep = array_values(array_filter($keep, fn ($p) => ! in_array($p, $toDelete, true)));
                }

                // tambah gambar baru
                if ($request->hasFile($name)) {
                    foreach ($request->file($name) as $file) {
                        if ($file) {
                            $keep[] = $file->store($def['key'], 'public');
                        }
                    }
                }

                $data[$name] = $keep;
            }
        }

        // Slug otomatis untuk resource yang punya field slug (berita, produk, dst)
        $hasSlug = collect($def['fields'])->contains(fn ($f) => $f['name'] === 'slug');
        if ($hasSlug) {
            $slug = trim((string) ($data['slug'] ?? ''));
            if ($slug === '') {
                $slug = Str::slug($data['title'] ?? $data['name'] ?? 'item');
            }
            $data['slug'] = $this->uniqueSlug($def['model'], $slug, $request);
        }

        return $data;
    }

    private function parseKv(string $text): array
    {
        $out = [];
        foreach (preg_split('/\r\n|\r|\n/', $text) as $line) {
            $line = trim($line);
            if ($line === '' || ! str_contains($line, ':')) {
                continue;
            }
            [$k, $v] = explode(':', $line, 2);
            $k = trim($k);
            if ($k !== '') {
                $out[$k] = trim($v);
            }
        }
        return $out;
    }

    private function parseParagraphs(string $text): array
    {
        $parts = preg_split('/(\r\n|\r|\n){2,}/', trim($text));
        return array_values(array_filter(array_map('trim', $parts), fn ($p) => $p !== ''));
    }

    private function uniqueSlug(string $model, string $slug, Request $request): string
    {
        $currentId = $request->route('id');
        $base = $slug;
        $i = 2;
        while ($model::where('slug', $slug)
            ->when($currentId, fn ($q) => $q->where('id', '!=', $currentId))
            ->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
