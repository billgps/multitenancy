<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Imports\ConsumableImport;
use App\Models\Consumable;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ConsumableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consumables = Consumable::with('inventory', 'inventory.device')->get();

        return view('consumable.index', ['consumables' => $consumables]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Inventory $inventory = null)
    {
        if ($inventory) {
            return view('consumable.create', ['inventory' => $inventory]);
        } else {            
            return view('consumable.create', ['inventories' => Inventory::with('device')->get()]);
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
            'component' => 'required',
            'brand' => 'required',
            'inventory_id' => 'required|integer',
        ]);

        if ($validated) {
            $consumable = new Consumable();
            $consumable->component = $request->component;
            $consumable->brand = $request->brand;
            $consumable->details = $request->details;
            $consumable->inventory_id = $request->inventory_id;
            $consumable->save();

            return redirect()->route('consumable.index')->with('success', 'New Entry Added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consumable  $consumable
     * @return \Illuminate\Http\Response
     */
    public function show(Consumable $consumable)
    {
        return view('consumable.show', [
            'consumable' => $consumable, 
            'inventory' => $consumable->inventory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consumable  $consumable
     * @return \Illuminate\Http\Response
     */
    public function edit(Consumable $consumable)
    {
        return view('consumable.edit', [
            'consumable' => $consumable, 
            'inventories' => Inventory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consumable  $consumable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consumable $consumable)
    {
        $validated = $request->validate([
            'component' => 'required',
            'brand' => 'required',
            'inventory_id' => 'required|integer',
        ]);

        if ($validated) {
            $consumable->component = $request->component;
            $consumable->brand = $request->brand;
            $consumable->details = $request->details;
            $consumable->inventory_id = $request->inventory_id;
            $consumable->update();

            return redirect()->route('consumable.show', ['consumable' => $consumable->id])->with('success', 'Entry Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consumable  $consumable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consumable $consumable)
    {
        $consumable->delete();

        return redirect()->route('consumable.index')->with('success', 'Entry Deleted');
    }

    public function import()
    {
        Excel::import(new ConsumableImport, request()->file('file'));

        return redirect()->route('consumable.index')->with('success', 'Data Imported!');
    }
}
