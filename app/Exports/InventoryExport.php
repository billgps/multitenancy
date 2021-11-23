<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventory::with(
            'latest_record', 
            'latest_condition',         
            'device',
            'identity',
            'identity.brand',
            'room'
        )->get();
    }

    /**
    * @var Invoice $invoice
    */
    public function map($inventory): array
    {
        return [
            $inventory->id,
            $inventory->barcode,
            $inventory->device->standard_name,
            $inventory->identity->brand->brand,
            $inventory->identity->model,
            $inventory->serial,
            $inventory->room->room_name,
            $inventory->latest_record->cal_date,
            $inventory->latest_record->result,
            $inventory->latest_condition->event_date,
            $inventory->latest_condition->status,
            $inventory->latest_condition->event,
            Carbon::parse($inventory->created_at)->toFormattedDateString()
        ];
    }

    public function headings() : array {
        return [
            'ID',
            'Barcode',
            'Nama Alat',
            'Merk',
            'Tipe',
            'Serial Number',
            'Ruangan',
            'Tanggal Kalibrasi',
            'Hasil Kalibrasi',
            'Tanggal Kejadian',
            'Kondisi',
            'Keterangan',
            'Created At'
        ];
    }
}
