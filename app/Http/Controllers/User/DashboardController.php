<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Record;

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
        $inventory = Inventory::with('device', 'room', 'brand', 'latest_condition', 'latest_record')->take(5)->orderBy('created_at', 'desc')->get();
        $record = Record::with('inventory.device')->take(5)->get();        

        return view('home', [
            'inventories' => $inventory,
            'records' => $record,
        ]);
    }
}
