<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Record;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $total      = 0;
        $scheduled  = 0;
        $calibrated = 0;
        $expired    = 0;
        $good       = 0;
        $broken     = 0;
        $passed     = 0;
        $failed     = 0;

        $query = "SELECT COUNT(barcode) AS subTotal, calibration_status FROM inventories AS i 
        INNER JOIN records AS r ON i.id=r.inventory_id 
        WHERE r.id = (SELECT MAX(rb.id) FROM records AS rb WHERE rb.inventory_id=r.inventory_id) 
        GROUP BY calibration_status";
        $groups = DB::select($query);
        foreach ($groups as $group) {
            $total += $group->subTotal;
            if ($group->calibration_status == 'Segera Dikalibrasi') {
                $scheduled = $group->subTotal;
            }

            if ($group->calibration_status == 'Terkalibrasi') {
                $calibrated = $group->subTotal;
            }

            if ($group->calibration_status == 'Expired') {
                $expired = $group->subTotal;
            }
        }

        $query = "SELECT COUNT(barcode) AS subTotal, `status` FROM inventories AS i 
        INNER JOIN conditions AS c ON i.id=c.inventory_id 
        WHERE c.id = (SELECT MAX(cb.id) FROM conditions AS cb WHERE cb.inventory_id=c.inventory_id) 
        GROUP BY status";
        $groups = DB::select($query);
        foreach ($groups as $group) {
            if ($group->status == 'Rusak') {
                $broken = $group->subTotal;
            }

            if ($group->status == 'Baik') {
                $good = $group->subTotal;
            }
        }

        $query = "SELECT COUNT(barcode) AS subTotal, `result` FROM inventories AS i 
        INNER JOIN records AS c ON i.id=c.inventory_id 
        WHERE c.id = (SELECT MAX(cb.id) FROM records AS cb WHERE cb.inventory_id=c.inventory_id) 
        GROUP BY result";
        $groups = DB::select($query);
        foreach ($groups as $group) {
            if ($group->result == 'Laik') {
                $passed = $group->subTotal;
            }

            if ($group->result == 'Tidak Laik') {
                $failed = $group->subTotal;
            }
        }
        
        // $total = Inventory::all()->count();
        // $scheduled = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
        //     $query->where('calibration_status', 'Segera Dikalibrasi');
        // })->count();
        // $calibrated = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
        //     $query->where('calibration_status', 'Terkalibrasi');
        // })->count();
        // $expired = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
        //     $query->where('calibration_status', 'Expired');
        // })->count();

        // $passed = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
        //     $query->where('result', 'Laik');
        // })->count();
        // $failed = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
        //     $query->where('result', 'Tidak Laik');
        // })->count();

        // $good = Inventory::with('latest_condition')->whereHas('latest_condition', function($query) {
        //     $query->where('status', 'Baik');
        // })->count();
        // $broken = Inventory::with('latest_condition')->whereHas('latest_condition', function($query) {
        //     $query->where('status', 'Rusak');
        // })->count();

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
