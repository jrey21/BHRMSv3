<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;
use App\Services\AuditLogService;

class AuditLogController extends Controller
{

    // Example for storing an entry
    public function store(Request $request)
    {
        $data = $request->all();
        $record = Model::create($data);
    
        // Log the action
        AuditLogService::logAction('CREATE', 'your_table_name', null, $record);
    
        return response()->json(['message' => 'Data stored successfully']);
    }
    
    // Example for updating an entry
    public function update(Request $request, $id)
    {
        $record = Model::findOrFail($id);
        $oldData = $record->toArray();
        $record->update($request->all());
    
        // Log the update
        AuditLogService::logAction('UPDATE', 'your_table_name', $oldData, $record);
    
        return response()->json(['message' => 'Data updated successfully']);
    }
    
    // Example for deleting an entry
    public function destroy($id)
    {
        $record = Model::findOrFail($id);
        $oldData = $record->toArray();
        $record->delete();
    
        // Log the deletion
        AuditLogService::logAction('DELETE', 'your_table_name', $oldData, null);
    
        return response()->json(['message' => 'Data deleted successfully']);
    }
    
}
