<?php

namespace App\Exports;

use App\Models\Inventory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InventoryDetailExport implements FromView, ShouldAutoSize
{
    protected $inventory;
    
    function __construct($inventory_id)
    {
        $this->inventory = Inventory::with('device', 'asset', 'latest_record', 'latest_condition', 'brand', 'identity', 'identity.brand', 'room')->find($inventory_id);
    }

    public function view(): View
    {
        $records = $this->inventory->records;
        foreach ($records as $rec) {
            $rec->activity;
        }

        $conditions = $this->inventory->conditions;
        $maintenances = $this->inventory->maintenances;

        return view('excel.inventory', [
            'inventory' => $this->inventory,
            'records' => $records,
            'conditions' => $conditions,
            'maintenances' => $maintenances
        ]);
    }
}
