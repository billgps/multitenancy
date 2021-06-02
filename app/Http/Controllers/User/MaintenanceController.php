<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Imports\MaintenanceImport;
use App\Models\Inventory;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maintenances = Maintenance::with('inventory', 'inventory.device')->get();

        return view('maintenance.index', ['maintenances' => $maintenances]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Inventory $inventory = null)
    {
        if ($inventory) {
            return view('maintenance.create', ['inventory' => $inventory]);
        } else {            
            return view('maintenance.create', ['inventories' => Inventory::with('device')->get()]);
        }
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
            'scheduled_date' => 'required|date',
            'done_date' => 'required|date',
            'personnel' => 'required|string',
            'inventory_id' => 'required|integer',
        ]);

        if ($validated) {
            $maintenance = new Maintenance();
            $maintenance->scheduled_date = $request->scheduled_date;
            $maintenance->done_date = $request->done_date;
            $maintenance->personnel = $request->personnel;
            $maintenance->inventory_id = $request->inventory_id;
            $maintenance->save();

            return redirect()->route('maintenance.index')->with('success', 'New Entry Added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(Maintenance $maintenance)
    {
        return view('maintenance.edit', [
            'maintenance' => $maintenance, 
            'inventories' => Inventory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $validated = $request->validate([
            'scheduled_date' => 'required|date',
            'done_date' => 'required|date',
            'personnel' => 'required|string',
            'inventory_id' => 'required|integer',
        ]);

        if ($validated) {
            $maintenance->scheduled_date = $request->scheduled_date;
            $maintenance->done_date = $request->done_date;
            $maintenance->personnel = $request->personnel;
            $maintenance->inventory_id = $request->inventory_id;
            $maintenance->update();

            return redirect()->route('maintenance.index')->with('success', 'Entry Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();

        return redirect()->route('maintenance.index')->with('success', 'Entr Deleted');
    }

    public function import()
    {
        Excel::import(new MaintenanceImport, request()->file('file'));

        return redirect()->route('maintenance.index')->with('success', 'Data Imported!');
    }
}
