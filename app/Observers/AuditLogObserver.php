<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogObserver
{
    public function created($model)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'table_name' => $model->getTable(),
            'new_data' => $model->toArray(),
            'ip_address' => request()->ip(),
        ]);
    }

    public function updated($model)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'table_name' => $model->getTable(),
            'old_data' => $model->getOriginal(),
            'new_data' => $model->getChanges(),
            'ip_address' => request()->ip(),
        ]);
    }

    public function deleted($model)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'table_name' => $model->getTable(),
            'old_data' => $model->toArray(),
            'ip_address' => request()->ip(),
        ]);
    }
}
