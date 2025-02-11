<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        return response()->json(AuditLog::with('user')->latest()->get());
    }

    public function getPreviousLogs()
    {
        // Fetch previous logs logic
        return response()->json(AuditLog::with('user')->oldest()->get());
    }

    public function store(Request $request)
    {
        $log = new AuditLog();
        $log->user_id = $request->user_id;
        $log->action = $request->action;
        $log->timestamp = now();
        $log->save();

        return response()->json(['message' => 'Log stored successfully']);
    }
}
