<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Imports\AssetImport;
use App\Models\Asset;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::with('inventory', 'inventory.device')->get();

        return view('asset.index', ['assets' => $assets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Inventory $inventory = null)
    {
        if ($inventory) {
            return view('asset.create', ['inventory' => $inventory]);
        } else {            
            return view('asset.create', ['inventories' => Inventory::with('device')->get()]);
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
            'price' => 'required|integer',
            'year_purchased' => 'required|integer|digits:4',
            'inventory_id' => 'required|integer',
        ]);

        if ($validated) {
            $asset = new Asset();
            $asset->price = $request->price;
            $asset->year_purchased = $request->year_purchased;
            $asset->inventory_id = $request->inventory_id;
            $asset->save();

            return redirect()->route('asset.index')->with('success', 'New Entry Added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        return view('asset.edit', [
            'asset' => $asset, 
            'inventories' => Inventory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'price' => 'required|integer',
            'year_purchased' => 'required|integer|digits:4',
            'inventory_id' => 'required|integer',
        ]);

        if ($validated) {
            $asset->price = $request->price;
            $asset->year_purchased = $request->year_purchased;
            $asset->inventory_id = $request->inventory_id;
            $asset->update();

            return redirect()->route('asset.index')->with('success', 'Entry Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('asset.index');
    }

    public function import()
    {
        Excel::import(new AssetImport, request()->file('file'));

        return redirect()->route('asset.index')->with('success', 'Data Imported');
    }
}
