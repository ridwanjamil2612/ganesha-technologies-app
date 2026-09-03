<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function adminCount(): int
    {
        $ids = Role::all()->filter(fn ($r) => $r->has('users'))->pluck('id');

        return User::whereIn('role_id', $ids)->count();
    }

    private function roleHasUsers(?int $roleId): bool
    {
        $role = Role::find($roleId);

        return $role ? $role->has('users') : false;
    }

    public function index()
    {
        $users = User::orderBy('name')->get();
        $roles = Role::pluck('label', 'id');

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $user = new User;
        $roles = Role::orderBy('id')->get();

        return view('admin.users.form', compact('user', 'roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|max:190|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role_id = $data['role_id'];
        $user->save();

        AuditLog::record('create', 'Pengguna', 'Menambah pengguna: ' . $user->name);

        return redirect()->route('admin.users.index')->with('ok', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('id')->get();

        return view('admin.users.form', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => ['required', 'email', 'max:190', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        // Jangan sampai tidak ada lagi yang bisa kelola user
        if ($this->roleHasUsers($user->role_id) && ! $this->roleHasUsers((int) $data['role_id']) && $this->adminCount() <= 1) {
            return back()->withErrors(['role_id' => 'Ini satu-satunya pengguna yang bisa Kelola User. Perannya tidak bisa diturunkan.'])->withInput();
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->role_id = $data['role_id'];
        $user->save();

        AuditLog::record('update', 'Pengguna', 'Mengubah pengguna: ' . $user->name);

        return redirect()->route('admin.users.index')->with('ok', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'Tidak bisa menghapus akun sendiri.']);
        }
        if ($this->roleHasUsers($user->role_id) && $this->adminCount() <= 1) {
            return back()->withErrors(['user' => 'Tidak bisa menghapus satu-satunya pengelola user.']);
        }

        $name = $user->name;
        $user->delete();

        AuditLog::record('delete', 'Pengguna', 'Menghapus pengguna: ' . $name);

        return redirect()->route('admin.users.index')->with('ok', 'Pengguna berhasil dihapus.');
    }
}
