<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    public static function logAction($action, $table, $oldData = null, $newData = null)
    {
        AuditLog::create([
            'user_id' => Auth::id(), // Get the authenticated user
            'action' => $action,
            'table_name' => $table,
            'old_data' => $oldData ? json_encode($oldData) : null,
            'new_data' => $newData ? json_encode($newData) : null,
            'ip_address' => Request::ip(),
        ]);
    }
}
