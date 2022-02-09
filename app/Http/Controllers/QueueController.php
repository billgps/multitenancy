<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\Inventory;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Log;
use App\Models\Notification;
use App\Notifications\ASPAKSyncUpdate;
use Illuminate\Support\Facades\Log as FacadesLog;
use Spatie\Multitenancy\Models\Tenant;

class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $queues = Queue::orderBy('created_at', 'desc')->get();

        return view('queue.index', ['queues' => $queues]);
    }

    public function logs(Queue $queue)
    {
        $logs = $queue->logs;

        return view('log.index', ['logs' => $logs]);
    }

    public function send(Queue $queue)
    {
        if ($queue->activity_id) {
            $token = 'xcdfae';
            $headers = [
                'Authorization: Bearer '.$token       
            ];
            $serialized = "";

            foreach (json_decode($queue->payload) as $item) {
                $serialized .= "Data[]={$item}&";
            }

            try {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://aspak.kemkes.go.id/monitoring/gps/add?ipid=IP3173002&id=".$queue->activity_id,
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $serialized,
                ));
    
                $response = json_decode(curl_exec($curl));
                $error = curl_error($curl);
                curl_close($curl);
    
                if ($error == "") {
                    $log = Log::create([
                        'queue_id' => $queue->id,
                        'response' => json_encode($response),
                        'error' => null,
                    ]);
                } else {
                    $log = Log::create([
                        'queue_id' => $queue->id,
                        'response' => json_encode($response),
                        'error' => $error,
                    ]);
                }
    
                if ($response->success) {
                    Tenant::where('id', $queue->tenant_id)->get()->eachCurrent(function (Tenant $tenant) use ($queue, $response) {
                        Tenant::current()->is($tenant);
    
                        preg_match_all('!\d+!', $response->msg, $message);
                        foreach (json_decode($queue->payload) as $index => $value) {
                            for ($i = 0; $i < count($message); $i++) {
                                if (count($message[0]) > 0) {
                                    if (intVal($message[0][$i]) === $index) {
                                        Inventory::where('id', json_decode($value)->inventory_id)->update([
                                            'is_verified' => 0
                                        ]);
                                    } else {
                                        Inventory::where('id', json_decode($value)->inventory_id)->update([
                                            'is_verified' => 1
                                        ]);
                                    }
                                } else {
                                    Inventory::where('id', json_decode($value)->inventory_id)->update([
                                        'is_verified' => 1
                                    ]);
                                }
                            }
                        }
                    });
    
                    $queue->update([
                        'status' => 'success'
                    ]);
                } else {
                    $queue->update([
                        'status' => 'failed'
                    ]);
                }
    
                $admins = Administrator::all();

                Notification::send($admins, new ASPAKSyncUpdate(
                    $response->data->accept,
                    $response->data->denied, 
                    $queue->status, 
                    $queue->id 
                ));

            } catch (\Throwable $th) {
                FacadesLog::error($th);
            }
        }

        return redirect()->route('queue.index');
    }

    public function batch(Request $request)
    {
        $validated = $request->validate([
            'queues' => 'required|array|min:1|max:50|distinct'
        ]);

        if ($validated) {
            /* commented because need to retreive queues as model
            $query = "SELECT * FROM `queues` WHERE `id` IN ('".implode("','",$request->queues)."')";
            $queues = DB::connection('host')->select($query); */

            $queues = Queue::whereIn('id', $request->queues)->get();

            if (!$queues) {
                return back()->with('error', "Queue not found code : 404");
            }

            foreach ($queues as $queue) {
                if ($queue->activity_id) {
                    $token = 'xcdfae';
                    $headers = [
                        'Authorization: Bearer '.$token       
                    ];
                    $serialized = "";
        
                    foreach (json_decode($queue->payload) as $item) {
                        $serialized .= "Data[]={$item}&";
                    }
        
                    try {
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "http://aspak.kemkes.go.id/monitoring/gps/add?ipid=IP3173002&id=".$queue->activity_id,
                            CURLOPT_HTTPHEADER => $headers,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => false,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => $serialized,
                        ));
            
                        $response = json_decode(curl_exec($curl));
                        $error = curl_error($curl);
                        curl_close($curl);
            
                        if ($error == "") {
                            Log::create([
                                'queue_id' => $queue->id,
                                'response' => json_encode($response),
                                'error' => null,
                            ]);
                        } else {
                            Log::create([
                                'queue_id' => $queue->id,
                                'response' => json_encode($response),
                                'error' => $error,
                            ]);
                        }
            
                        if ($response->success) {
                            Tenant::where('id', $queue->tenant_id)->get()->eachCurrent(function (Tenant $tenant) use ($queue, $response) {
                                Tenant::current()->is($tenant); // returns true;
            
                                preg_match_all('!\d+!', $response->msg, $message);
                                foreach (json_decode($queue->payload) as $index => $value) {
                                    for ($i = 0; $i < count($message); $i++) {
                                        if (count($message[0]) > 0) {
                                            if (intVal($message[0][$i]) === $index) {
                                                Inventory::where('id', json_decode($value)->inventory_id)->update([
                                                    'is_verified' => 0
                                                ]);
                                            } else {
                                                Inventory::where('id', json_decode($value)->inventory_id)->update([
                                                    'is_verified' => 1
                                                ]);
                                            }
                                        } else {
                                            Inventory::where('id', json_decode($value)->inventory_id)->update([
                                                'is_verified' => 1
                                            ]);
                                        }
                                    }
                                }
                            });
            
                            $queue->update([
                                'status' => 'success'
                            ]);
                        } else {
                            $queue->update([
                                'status' => 'failed'
                            ]);
                        }
                    } catch (\Throwable $th) {
                        FacadesLog::error($th);
                    }
                } else {
                    return back()->with('error', "Queue ID #".$queue->id." does not have property `activity_id`");
                }
            }

            return redirect()->route('queue.index')->with('success', "Successfully executed ".count($queues)." queues");
        }
    }

    public function retry(Request $request)
    {
        $validated = $request->validate([
            'activity_id' => 'required|numeric',
            'tenant_id' => 'required|numeric',
            'payload' => 'required'
        ]);

        if ($validated) {
            Queue::create($validated);

            return redirect()->route('queue.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function show(Queue $queue)
    {
        $inventoriyIDs = array();
        foreach (json_decode($queue->payload) as $p) {
            array_push($inventoriyIDs, json_decode($p));
        }

        // $inventoriyIDs = implode(',', $inventoriyIDs);

        // opted for just showing the payload details
        // $tenantDB = $queue->tenant->database;
        // $query = "SELECT `id`, standard_name FROM ".$tenantDB.".inventories AS i WHERE `id` IN (".$inventoriyIDs.") INNER JOIN ".$tenantDB.".devices AS d ON d.id = i.device_id";
        // $inventories = DB::connection('tenant')->select($query);

        return view('queue.show', ['queue' => $queue, 'payload' => $inventoriyIDs]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function edit(Queue $queue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Queue $queue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Queue $queue)
    {
        $queue->logs()->delete();
        $payload = json_decode($queue->payload);
        $tenant = $queue->tenant->database;
        $ids = array();

        foreach ($payload as $p) {
            array_push($ids, json_decode($p)->inventory_id);
        }

        $query = "UPDATE ".$tenant.".inventories SET `aspak_code` = null WHERE `id` IN (".implode(',', $ids).")";
        DB::connection('tenant')->update($query);

        $queue->delete();

        return response(['message' => "successfully deleted", 200]);
    }
}
