<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Condition;
use App\Models\Inventory;
use Illuminate\Http\Request;

use App\Rules\ImageUpload as RulesImageUpload;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory = Inventory::with('device', 'brand', 'identity', 'room', 'latest_condition', 'latest_record')->orderBy('created_at', 'desc')->get();

        return view('inventory.index', ['inventories' => $inventory]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'barcode' => 'required|unique:inventories|max:255',
            'serial' => 'required|unique:inventories|max:255',
            'device_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'identity_id' => 'required|integer',
            'room_id' => 'required|integer',
            'picture' => new RulesImageUpload
        ]);

        if ($validated) {
            $picture = $request->file('picture');

            if ($picture != null) {
                $name = $picture->getClientOriginalName();
                $picture->move(public_path().'/images/', $name);
            }

            $inventory = new Inventory();
            $inventory->barcode = $request->barcode;
            $inventory->serial = $request->serial;
            $inventory->device_id = $request->device_id;
            $inventory->brand_id = $request->brand_id;
            $inventory->identity_id = $request->identity_id;
            $inventory->room_id = $request->room_id;
            $inventory->picture = ($picture != null) ? $name : 'no_image.jpg';
            $inventory->save();

            if ($request->event_date != null) {
                $worksheet = $request->file('worksheet');
                $worksheetName = 'Belum Diupload';
    
                if ($worksheet != null) {
                    $worksheetName = $worksheet->getClientOriginalName();
                    $worksheet->move(public_path().'/worksheet/', $worksheetName);
                }

                $condition = new Condition();
                $condition->event_date = $request->event_date;
                $condition->event = $request->event;
                $condition->status = $request->status;
                $condition->user_id = $request->user_id;
                $condition->worksheet = $worksheetName;
                $condition->inventory_id = $inventory->id;
                $condition->save();
            }

            return redirect()->route('inventory.index')->with('success', 'New Entry Added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventory = Inventory::with('device', 'records', 'conditions', 'maintenances', 'asset', 'latest_record', 'latest_condition', 'brand', 'identity', 'room')->find($id);

        return view('inventory.show', [
            'inventory' => $inventory, 
        ]);
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
}
