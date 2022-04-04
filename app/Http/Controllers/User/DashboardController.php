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

    public function index()
    {
        $total      = 0;
        $scheduled  = 0;
        $calibrated = 0;
        $expired    = 0;
        $good       = 0;
        $broken     = 0;
        $passed     = 0;
        $failed     = 0;

        $query = "SELECT COUNT(barcode) AS subTotal, `calibration_status` FROM inventories AS i 
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
            if ($group->result == 'Tidak Laik') {
                $failed += $group->subTotal;
            }

            else if ($group->result == 'Laik') {
                $passed = $group->subTotal;
            }
        }
    
        $inventories = Inventory::with('device', 'room', 'brand', 'latest_record')->orderBy('created_at', 'desc')->take(5)->get();
        $pending = Inventory::with('latest_record')->whereHas('latest_record', function($query) {
            $query->where('calibration_status', 'Segera Dikalibrasi');
        })->take(5)->get();

        $records = Record::with('inventory.device')->orderBy('created_at', 'desc')->take(8)->get();
        $must_calibrates = Inventory::with('device', 'latest_record')->whereHas('latest_record', function($query) {
            $query->where('calibration_status', 'Segera Dikalibrasi')
                ->orWhere('calibration_status', 'Expired');
        })->get();
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
            'must_calibrates' => $must_calibrates,
            'total' => Inventory::all()->count(),
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

    public function pieChart($param)
    {
        $labels = array();
        $values = array();

        switch ($param) {
            case 'room':
                $result = DB::select('SELECT room_name, COUNT(i.id) as inventories FROM inventories as i RIGHT JOIN rooms ON i.room_id = rooms.id GROUP BY room_id');
                foreach ($result as $val) {
                    array_push($labels, $val->room_name);
                    array_push($values, $val->inventories);
                }
                break;

            case 'device':
                $result = DB::select('SELECT standard_name, COUNT(i.id) as inventories FROM inventories as i RIGHT JOIN devices ON i.device_id = devices.id GROUP BY device_id');
                foreach ($result as $val) {
                    array_push($labels, $val->standard_name);
                    array_push($values, $val->inventories);
                }
                break;
            
            default:
                # code...
                break;
        }

        $data = array(
            'labels' => $labels,
            'datasets' => $values
        );

        return response(json_encode($data), 200);
    }
}
