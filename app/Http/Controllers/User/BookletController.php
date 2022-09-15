<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use PDF;

class BookletController extends Controller
{
    public function index()
    {
        $chunks = Inventory::select('id', 'barcode')->get()->chunk(100);

        return view('booklet.index', ['chunks' => $chunks]);
    }

    public function generate($offset)
    {
        $inventories = Inventory::offset($offset * 100)->take(100)->get();

        ini_set('max_execution_time', 300);
        $pdf = PDF::loadView('booklet.pdf', ['inventories' => $inventories]);

        return $pdf->stream('booklet_'.strtotime(date('Y-m-d H:i:s')).'.pdf');
        // return view('booklet.pdf', ['inventories' => $inventories]);
    }
}
