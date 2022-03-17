<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Administrator;
use App\Models\Inventory;
use App\Models\Log;
use App\Models\Queue;
use App\Notifications\ASPAKSyncUpdate;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Notification;
use Spatie\Multitenancy\Models\Tenant;

class AspakSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:aspak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync tenant inventory database that has been mapped and ready to aspak monitoring API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $queues = Queue::where('status', 'queue')->orderBy('created_at', 'asc')->first();

        if (!$queues) {
            FacadesLog::warning("there is no queue");
        }
        
        if ($queues->activity_id) {
            $token = 'xcdfae';
            $headers = [
                'Authorization: Bearer '.$token       
            ];
            $serialized = "";

            foreach (json_decode($queues->payload) as $item) {
                $serialized .= "Data[]={$item}&";
            }

            try {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://aspak.kemkes.go.id/monitoring/gps/add?ipid=IP3173002&id=".$queues->activity_id,
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
                        'queue_id' => $queues->id,
                        'response' => json_encode($response),
                        'error' => null,
                    ]);
                } else {
                    $log = Log::create([
                        'queue_id' => $queues->id,
                        'response' => json_encode($response),
                        'error' => $error,
                    ]);
                }
    
                if ($response->success) {
                    Tenant::where('id', $queues->tenant_id)->get()->eachCurrent(function (Tenant $tenant) use ($queues, $response) {
                        Tenant::current()->is($tenant); // returns true;
    
                        preg_match_all('!\d+!', $response->msg, $message);
                        foreach (json_decode($queues->payload) as $index => $value) {
                            for ($i = 0; $i < count($message); $i++) {
                                if (count($message[0]) > 0) {
                                    if (intVal($message[0][$i]) === $index) {
                                        // echo('failed:'.$index);
                                        Inventory::where('id', json_decode($value)->inventory_id)->update([
                                            'is_verified' => 0
                                        ]);
                                    } else {
                                        // echo('success:'.$index);
                                        Inventory::where('id', json_decode($value)->inventory_id)->update([
                                            'is_verified' => 1
                                        ]);
                                    }
                                } else {
                                    // echo('success:'.$index);
                                    Inventory::where('id', json_decode($value)->inventory_id)->update([
                                        'is_verified' => 1
                                    ]);
                                }
                            }
                        }
                    });
    
                    $queues->update([
                        'status' => 'success'
                    ]);
                } else {
                    $queues->update([
                        'status' => 'failed'
                    ]);
                }
    
                $admins = Administrator::all();

                Notification::send($admins, new ASPAKSyncUpdate(
                    $response->data->accept,
                    $response->data->denied, 
                    $queues->status, 
                    $queues->id 
                ));

            } catch (\Throwable $th) {
                FacadesLog::error($th);
            }
        }

        return 0;
    }
}
