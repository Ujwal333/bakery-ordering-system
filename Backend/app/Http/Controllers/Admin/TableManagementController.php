<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TableReservation;
use App\Models\Order;
use Illuminate\Http\Request;

class TableManagementController extends Controller
{
    public function index()
    {
        $tables = TableReservation::orderBy('table_number')->get();
        // If no tables exist, initialize 1-20
        if ($tables->isEmpty()) {
            for ($i = 1; $i <= 20; $i++) {
                TableReservation::create([
                    'table_number' => $i,
                    'status' => 'available'
                ]);
            }
            $tables = TableReservation::orderBy('table_number')->get();
        }
        
        return view('admin.dinein.index', compact('tables'));
    }

    public function updateStatus(Request $request, TableReservation $table)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,reserved'
        ]);

        $table->update([
            'status' => $request->status,
            'current_order_id' => $request->status === 'available' ? null : $table->current_order_id
        ]);

        return back()->with('success', "Table {$table->table_number} status updated to {$request->status}.");
    }

    public function free(TableReservation $table)
    {
        $table->free();
        return back()->with('success', "Table {$table->table_number} is now available.");
    }
}
