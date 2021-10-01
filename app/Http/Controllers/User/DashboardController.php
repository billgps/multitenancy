<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Record;
use Carbon\Carbon;

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
        // $temp = array();
        $total = Inventory::all()->count();
        $scheduled = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
            $query->where('calibration_status', 'Segera Dikalibrasi');
        })->count();
        $calibrated = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
            $query->where('calibration_status', 'Terkalibrasi');
        })->count();
        $expired = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
            $query->where('calibration_status', 'Expired');
        })->count();

        $passed = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
            $query->where('result', 'Laik');
        })->count();
        $failed = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
            $query->where('result', 'Tidak Laik');
        })->count();

        $good = Inventory::with('latest_condition')->whereHas('latest_condition', function($query) {
            $query->where('status', 'Baik');
        })->count();
        $broken = Inventory::with('latest_condition')->whereHas('latest_condition', function($query) {
            $query->where('status', 'Rusak');
        })->count();

        $inventories = Inventory::with('device', 'room', 'brand', 'latest_record')->orderBy('created_at', 'desc')->take(5)->get();
        $pending = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
            $query->where('calibration_status', 'Segera Dikalibrasi');
        })->take(5)->get();

        $records = Record::with('inventory.device')->orderBy('created_at', 'desc')->take(8)->get();
        $current = date('Y-m-d h:i:s a', time());
        $before = date('Y-m-d h:i:s a', strtotime("-5months", strtotime($current)));

        $months = Inventory::with('latest_condition')->whereHas('latest_condition', function($query) use ($current, $before) {
            $query->where('status', 'Rusak')
                ->whereBetween('event_date', [$before, $current])
                ->orderBy('event_date', 'asc');
        })->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->latest_condition->event_date)->format('M');
        });

        // foreach ($months as $month) {
        //     array_push($temp, $month->count());
        // }
        
        /*
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
        */
        
        return view('home', [
            'inventories' => $inventories,
            'pending' => $pending,
            'records' => $records,
            'total' => $total,
            'scheduled' => $scheduled,
            'calibrated' => $calibrated,
            'expired' => $expired,
            'good' => $good,
            'broken' => $broken,
            'passed' => $passed,
            'failed' => $failed,
            'statistic' => $months
        ]);
    }
}
