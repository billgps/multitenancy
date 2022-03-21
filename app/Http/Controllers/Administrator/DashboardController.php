<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;

class DashboardController extends Controller
{
    public function __construct()
    {
        /*
         * Uncomment the line below if you want to use verified middleware
         */
        //$this->middleware('verified:administrator.verification.notice');
    }

    public function index(){
        $tenants = Tenant::orderBy('updated_at', 'desc')->get();
        $dataCount = array();
        foreach ($tenants as $t) {
            $data = DB::select('SELECT COUNT(`id`) as "count" FROM '.$t->database.'.inventories');
            array_push($dataCount, $data[0]->count);
        }

        $queues = Queue::where('status', 'success')->get()->count();

        return view('home', ['tenants' => $tenants, 'data' => $dataCount, 'queue' => $queues]);
    }
}
