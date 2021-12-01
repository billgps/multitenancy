<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Device;
use App\Models\Inventory;
use App\Models\Nomenclature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ASPAKController extends Controller
{
    public function index()
    {
        $query = "SELECT device_id FROM inventories WHERE is_verified = 0 GROUP BY device_id";
        $inventories = DB::select($query);
        $index = array();
        foreach ($inventories as $inv) {
            array_push($index, $inv->device_id);
        }

        $devices = Device::find($index);
        $nomenclatures = DB::connection('host')->select('SELECT `code`, `name` FROM nomenclatures');
        
        return view('aspak.index', ['devices' => $devices, 'nomenclatures' => $nomenclatures]);
    }

    public function create($id)
    {
        $invo = Device::with('inventories', 'inventories.brand', 'inventories.identity')->find($id);
        $nomenclatures = DB::connection('host')->select('SELECT `code`, `name` FROM nomenclatures');
        
        return view('aspak.create', ['invo' => $invo, 'nomenclatures' => $nomenclatures]);
    }

    public function ajaxMap(Device $device)
    {
        // $similar = Nomenclature::where('name', 'like', '%'.$device->standard_name.'%')->get();
        $query = 'SELECT * FROM nomenclatures WHERE MATCH(`name`) AGAINST ("'.$device->standard_name.'" IN BOOLEAN MODE) > 3';
        $similar = DB::connection('host')->select($query);

        return response()->json(['data' => $similar], 200);
    }
}
