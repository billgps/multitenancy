<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Condition;
use App\Models\Inventory;
use App\Models\Record;

class DashboardController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:user.verification.notice');
    }


    public function index(){
        $scheduled = 0;
        $calibrated = 0;
        $usable = 0;
        $non_usable = 0;
        $good = 0;
        $broken = 0;

        $inventories = Inventory::with('device', 'room', 'brand', 'latest_condition', 'latest_record')->orderBy('created_at', 'desc')->get();
        $displayInventories = Inventory::with('device', 'room', 'brand', 'latest_record')->orderBy('created_at', 'desc')->take(5)->get();
        $need_calibrations = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
            $query->where('calibration_status', 'Segera Dikalibrasi');
        })->take(5)->get();
        $records = Record::with('inventory.device')->orderBy('created_at', 'desc')->take(5)->get();

        foreach ($inventories as $inventory) {
            if ($inventory->latest_record->calibration_status == 'Terkalibrasi') {
                $calibrated++;
            }

            else if ($inventory->latest_record->calibration_status == 'Segera Dikalibrasi') {
                $scheduled++;
            }

            if ($inventory->latest_record->result == 'Laik') {
                $usable++;
            }

            else if ($inventory->latest_record->result == 'Tidak Laik') {
                $non_usable++;
            }

            if ($inventory->latest_condition->status == 'Baik') {
                $good++;
            }

            else if ($inventory->latest_condition->status == 'Rusak') {
                $broken++;
            }
        }
        
        return view('home', [
            'inventories' => $inventories,
            'displayInventories' => $displayInventories,
            'need_calibrations' => $need_calibrations,
            'records' => $records,
            'need_calibrations' => $scheduled,
            'scheduled' => $scheduled,
            'calibrated' => $calibrated,
            'good' => $good,
            'broken' => $broken,
            'usable' => $usable,
            'non_usable' => $non_usable
        ]);
    }
}
