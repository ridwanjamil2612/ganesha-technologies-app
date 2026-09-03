<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $action = $request->query('action');
        $logs = AuditLog::query()
            ->when($action, fn ($q) => $q->where('action', $action))
            ->orderByDesc('id')
            ->paginate(30)
            ->withQueryString();

        $actions = ['login', 'logout', 'create', 'update', 'delete'];

        return view('admin.audit.index', compact('logs', 'actions', 'action'));
    }

    public function clear()
    {
        $deleted = AuditLog::where('created_at', '<', now()->subDays(90))->delete();

        return redirect()
            ->route('admin.audit.index')
            ->with('ok', "Log lebih dari 90 hari dibersihkan ($deleted baris).");
    }
}
