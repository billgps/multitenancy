<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Resources\InventoryResource;

class InventoryAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::with('device', 'identity.brand', 'room', 'latest_condition', 'latest_record')->get();

        return response()->json(InventoryResource::collection($inventories), 200);
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
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        return response()->json(new InventoryResource($inventory->loadMissing([
            'device', 
            'identity.brand', 
            'room', 
            'latest_condition', 
            'latest_record',
            'records',
            'conditions',
            'maintenances',
            'asset'
        ])), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }

    /**
     * retreive barcode and redirec to show with id
     */
    public function scan($barcode)
    {
        $inventory = Inventory::where('barcode', $barcode)->count();
        if ($inventory > 1) {
            return response()->json('Barcode has duplicates!', 500);
        }

        else if ($inventory < 1 ) {
            return response()->json('Barcode does not exist', 404);
        }

        else {
            $inventory = Inventory::where('barcode', $barcode)->first();
            
            return redirect()->route('api.inventory.show', ['inventory' => $inventory->id]);
        }
    }
}
