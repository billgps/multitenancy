<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Brand;
use App\Models\Device;
use App\Models\Inventory;
use App\Models\Nomenclature;
use App\Models\Queue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;

class ASPAKController extends Controller
{
    public function index()
    {
        $query = "SELECT devices.id, standard_name, COUNT(i.id) as total, (SELECT COUNT(id) FROM inventories 
                    WHERE device_id = i.device_id AND aspak_code IS NOT null) as mapped FROM devices 
                    LEFT JOIN inventories as i ON devices.id=i.device_id WHERE i.is_verified=0 GROUP BY i.device_id";
        $devices = DB::select($query);

        // dd($devices);
        
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
                $inventories = Inventory::where('device_id', $request->id)->get();
            } else {
                Inventory::where('id', $request->id)->update(['aspak_code' => $request->code_]);
                $inventories = Inventory::where('id', $request->id)->get();
            }

            $this->apiMap($inventories);

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

    function apiMap(Collection $inventories)
    {
        $payload = array();
        $counter = 0;

        foreach ($inventories as $inv) {
            if ($inv->latest_record->result == 'Laik') {
                $laik = 1;
            } else {
                $laik = 0;
            }

            $array = [
                'inventory_id' => $inv->id,
                'cd_alat' => $inv->aspak_code,
                'cd_ruang' => 0,
                'sn' => $inv->serial,
                'merk' => $inv->identity->brand->brand,
                'tipe' => $inv->identity->model,
                'tgl' => $inv->latest_record->cal_date,
                'laik' => $laik,
                'petugas' => 'Null',
                'tgl_ser' => $inv->latest_record->cal_date,
                'cttn' => '-',
                'metode' => 0,
                'lokasi' => $inv->room->room_name,
                'no_ser' => $inv->latest_record->label
            ];

            if (count($payload) % 10 == 0 && $counter != 0) {
                $counter++;
                Queue::create([
                    'status' => 'queue',
                    'payload' => json_encode($payload),
                    'tenant_id' => Tenant::current()->id,
                    'activity_id' => Activity::active()->aspak_id
                ]);

                $payload = array();
                array_push($payload, json_encode($array));

                if (count($inventories) === $counter) {
                    array_push($payload, json_encode($array));
                    Queue::create([
                        'status' => 'queue',
                        'payload' => json_encode($payload),
                        'tenant_id' => Tenant::current()->id,
                        'activity_id' => Activity::active()->aspak_id
                    ]);
                }
            } else {
                if (count($inventories) - 1 === $counter) {
                    array_push($payload, json_encode($array));
                    Queue::create([
                        'status' => 'queue',
                        'payload' => json_encode($payload),
                        'tenant_id' => Tenant::current()->id,
                        'activity_id' => Activity::active()->aspak_id
                    ]);
                } else {
                    array_push($payload, json_encode($array));
                    $counter++;
                }
            }
        }

        return 0;
    }
}
