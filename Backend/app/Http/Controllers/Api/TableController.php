<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TableReservation;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Get all available tables
     */
    public function getAvailableTables()
    {
        // Initialize all tables if they don't exist
        $this->initializeTables();
        
        $availableTables = TableReservation::where('status', 'available')
            ->pluck('table_number')
            ->toArray();
        
        // Ensure all tables 1-20 exist, mark missing ones as available
        $allTables = range(1, 20);
        
        return response()->json([
            'available_tables' => $availableTables,
            'total_tables' => 20,
            'occupied_count' => 20 - count($availableTables)
        ]);
    }
    
    /**
     * Initialize all 20 tables in database
     */
    private function initializeTables()
    {
        for ($i = 1; $i <= 20; $i++) {
            TableReservation::firstOrCreate(
                ['table_number' => $i],
                ['status' => 'available']
            );
        }
    }
    
    /**
     * Get table status
     */
    public function getTableStatus($tableNumber)
    {
        $table = TableReservation::where('table_number', $tableNumber)->first();
        
        if (!$table) {
            $table = TableReservation::create([
                'table_number' => $tableNumber,
                'status' => 'available'
            ]);
        }
        
        return response()->json([
            'table_number' => $tableNumber,
            'status' => $table->status,
            'current_order' => $table->currentOrder
        ]);
    }
}
