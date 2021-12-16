<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Queue;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
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
        
        if ($queues->activity_id) {
            $token = 'xcdfae';
            $headers = [
                'Authorization: Bearer '.$token       
            ];
            $serialized = "";
            $codes = array();

            foreach (json_decode($queues->payload) as $item) {
                $serialized .= "Data[]={$item}&";
                array_push($codes, json_decode($item)->cd_alat);
            }

            dd($codes);

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

            if ($response->success) {

            }
        }

        return 0;
    }
}
