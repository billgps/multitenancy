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
        $query = "SELECT devices.id, standard_name, COUNT(i.id) as total, (SELECT COUNT(id) FROM inventories 
                    WHERE device_id = i.device_id AND aspak_code IS NOT null) as mapped FROM devices 
                    LEFT JOIN inventories as i ON devices.id=i.device_id WHERE i.is_verified=0 GROUP BY i.device_id";
        $devices = DB::select($query);
        // dd($inventories);
        // $index = array();
        // foreach ($inventories as $inv) {
        //     array_push($index, $inv->device_id);
        // }

        // $devices = Device::find($index);
        $nomenclatures = DB::connection('host')->select('SELECT `code`, `name` FROM nomenclatures');
        
        return view('aspak.index', ['devices' => $devices, 'nomenclatures' => $nomenclatures]);
    }

    public function create($id)
    {
        $invo = Device::with('inventories', 'inventories.brand', 'inventories.identity')->find($id);
        $nomenclatures = DB::connection('host')->select('SELECT `code`, `name` FROM nomenclatures');
        
        return view('aspak.create', ['invo' => $invo, 'nomenclatures' => $nomenclatures]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'input_parameter' => 'string|required',
            'code_'  => 'numeric|required'
        ]);

        if ($validated) {
            if ($request->input_parameter == 'device') {
                Inventory::where('device_id', $request->id)->update(['aspak_code' => $request->code_]);
            } else {
                Inventory::where('id', $request->id)->update(['aspak_code' => $request->code_]);
            }

            return back()->with('success', 'Code berhasil ditambahkan');
        }
    }

    public function ajaxMap(Device $device)
    {
        // $similar = Nomenclature::where('name', 'like', '%'.$device->standard_name.'%')->get();
        $query = 'SELECT * FROM nomenclatures WHERE MATCH(`name`) AGAINST ("'.$device->standard_name.'" IN BOOLEAN MODE) > 3';
        $similar = DB::connection('host')->select($query);

        return response()->json(['data' => $similar], 200);
    }
}
