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
        LEFT JOIN inventories as i ON devices.id=i.device_id INNER JOIN
        records ON i.id=records.inventory_id WHERE i.is_verified=0 
        AND records.calibration_status=\"Terkalibrasi\" GROUP BY i.device_id";
        $devices = DB::select($query);
        
        $nomenclatures = DB::connection('host')->select('SELECT `code`, `name` FROM nomenclatures');
        
        return view('aspak.index', ['devices' => $devices, 'nomenclatures' => $nomenclatures]);
    }

    public function store()
    {
        $resultMsg = array();
        $devices = Device::all();

        foreach ($devices as $key => $value) {
            if ($value->nomenclature != null) {         
                $oldQueue = array();
                $inventories = Inventory::where('device_id', $value->id)->where('is_verified', false)->get();
    
                if (count($inventories) > 0) {
                    foreach ($inventories as $inv) {
                        array_push($oldQueue, $inv->queue_id);
                    }
        
                    $oldQueue = array_unique($oldQueue);
        
                    try {
                        if (count($oldQueue) > 0) {
                            Queue::destroy($oldQueue);
                        }
            
                        $this->apiMap($inventories);
                    } catch (\Throwable $th) {
                        return response(["err" => "Error creating queue : ".$th->getMessage(), "msg" => $resultMsg], 500);
                    }
        
                    // Inventory::where('device_id', $inv->device_id)->update(['aspak_code' => $inv->device->nomenclature->aspak_code, 'queue_id' => $queue->id]);
        
                    array_push($resultMsg, "queues created for device ".$value->standard_name);
                } else {
                    array_push($resultMsg, "device ".$value->standard_name." already verified");
                }
    
            } else {
                array_push($resultMsg, "no nomenclature set for device ".$value->standard_name." device ID: ".$value->id);
            }
        }

        return response(["msg" => $resultMsg], 200);
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
                $queue = Queue::create([
                    'status' => 'queue',
                    'payload' => json_encode($payload),
                    'tenant_id' => Tenant::current()->id,
                    'activity_id' => Activity::active()->aspak_id
                ]);

                $payload = array();
                array_push($payload, json_encode($array));

                if (count($inventories) === $counter) {
                    array_push($payload, json_encode($array));
                    $queue = Queue::create([
                        'status' => 'queue',
                        'payload' => json_encode($payload),
                        'tenant_id' => Tenant::current()->id,
                        'activity_id' => Activity::active()->aspak_id
                    ]);
                }
            } else {
                if (count($inventories) - 1 === $counter) {
                    array_push($payload, json_encode($array));
                    $queue = Queue::create([
                        'status' => 'queue',
                        'payload' => json_encode($payload),
                        'tenant_id' => Tenant::current()->id,
                        'activity_id' => Activity::active()->aspak_id
                    ]);
                } else {
                    $queue = null;
                    array_push($payload, json_encode($array));
                    $counter++;
                }
            }

            if ($queue) {   
                $inv->update([
                    'queue_id' => $queue->id
                ]);
            }
        }
    }
}
