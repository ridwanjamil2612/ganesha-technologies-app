<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;
use App\Support\Perms;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id')->get();
        $perms = Perms::all();
        $counts = User::selectRaw('role_id, count(*) as c')->groupBy('role_id')->pluck('c', 'role_id');

        return view('admin.roles.index', compact('roles', 'perms', 'counts'));
    }

    public function create()
    {
        $role = new Role;
        $perms = Perms::all();

        return view('admin.roles.form', compact('role', 'perms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label'         => 'required|string|max:80',
            'permissions'   => 'array',
            'permissions.*' => 'in:' . implode(',', Perms::keys()),
        ]);

        $role = new Role;
        $role->label = $data['label'];
        $role->name = Str::slug($data['label']) . '-' . Str::lower(Str::random(4));
        $role->permissions = array_values($data['permissions'] ?? []);
        $role->is_system = false;
        $role->save();

        AuditLog::record('create', 'Peran', 'Membuat peran: ' . $role->label);

        return redirect()->route('admin.roles.index')->with('ok', 'Peran berhasil dibuat.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $perms = Perms::all();

        return view('admin.roles.form', compact('role', 'perms'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        if ($role->is_system) {
            return back()->withErrors(['role' => 'Peran sistem (Administrator) tidak bisa diubah.']);
        }

        $data = $request->validate([
            'label'         => 'required|string|max:80',
            'permissions'   => 'array',
            'permissions.*' => 'in:' . implode(',', Perms::keys()),
        ]);

        $role->label = $data['label'];
        $role->permissions = array_values($data['permissions'] ?? []);
        $role->save();

        AuditLog::record('update', 'Peran', 'Mengubah peran: ' . $role->label);

        return redirect()->route('admin.roles.index')->with('ok', 'Peran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if ($role->is_system) {
            return back()->withErrors(['role' => 'Peran sistem tidak bisa dihapus.']);
        }
        if (User::where('role_id', $role->id)->exists()) {
            return back()->withErrors(['role' => 'Peran ini masih dipakai pengguna. Pindahkan pengguna dulu.']);
        }
        $label = $role->label;
        $role->delete();

        AuditLog::record('delete', 'Peran', 'Menghapus peran: ' . $label);

        return redirect()->route('admin.roles.index')->with('ok', 'Peran berhasil dihapus.');
    }
}
