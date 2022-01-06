<?php

namespace App\Exports;

use App\Models\Inventory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class InventoryDetailExport implements FromView, ShouldAutoSize, WithDrawings
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

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path($this->inventory->picture));
        $drawing->setHeight(200);
        $drawing->setCoordinates('J3');

        return $drawing;
    }
}
