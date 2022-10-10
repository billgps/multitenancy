<?php

namespace App\Http\Controllers\User;

use App\Exports\InventoryDetailExport;
use App\Exports\InventoryExport;
use App\Exports\InventoryRawExport;
use App\Http\Controllers\Controller;
use App\Imports\InventoryImport;
use App\Models\Brand;
use App\Models\Condition;
use App\Models\Device;
use App\Models\Inventory;
use App\Models\Nomenclature;
use App\Models\Record;
use App\Models\Room;
use Illuminate\Http\Request;

use App\Rules\ImageUpload as RulesImageUpload;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Multitenancy\Models\Tenant;

use PDF;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(app('currentTenant'));
        $inventory = Inventory::with('device', 'brand', 'identity', 'identity.brand', 'room', 'latest_condition', 'latest_record')->orderBy('created_at', 'desc')->paginate(20);

        return view('inventory.index', ['inventories' => $inventory]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $devices = Device::all();
        $brands = Brand::all();
        $rooms = Room::all();
        $nomenclatures = Nomenclature::all();

        return view('inventory.create', [
            'devices' => $devices,
            'brands' => $brands,
            'rooms' => $rooms,
            'nomenclatures' => $nomenclatures
        ]);
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
            // 'brand_id' => 'required|integer',
            'identity_id' => 'required|integer',
            'room_id' => 'required|integer',
            'picture' => new RulesImageUpload
        ]);

        $latest_id = Inventory::max('id');

        if ($validated) {
            $picture = $request->file('picture');

            $inventory = new Inventory();
            $inventory->barcode = $request->barcode;
            $inventory->serial = $request->serial;
            $inventory->device_id = $request->device_id;
            $inventory->identity_id = $request->identity_id;
            $inventory->room_id = $request->room_id;
            $inventory->price = $request->price;
            $inventory->year_purchased = $request->year_purchased;
            $inventory->supplier = $request->supplier;
            $inventory->penyusutan = $request->penyusutan;
            if ($picture) {
                $path = ($picture != null) ? Tenant::current()->domain.'/'.'picture_'.($latest_id + 1).'.'.$picture->guessExtension() : 'no_image.jpg';
                $inventory->picture = '/images/'.$path;
                $picture->move(public_path().'/images/'.Tenant::current()->domain.'/', 'picture_'.($latest_id + 1).'.'.$picture->guessExtension());
            }
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
        $inventory = Inventory::with('device', 'records', 'conditions', 'maintenances', 'asset', 'latest_record', 'latest_condition', 'brand', 'identity', 'identity.brand', 'room')->find($id);

        return view('inventory.show', [
            'inventory' => $inventory, 
            'records' => $inventory->records,
            'conditions' => $inventory->conditions,
            'maintenances' => $inventory->maintenances,
            'consumables' => $inventory->consumables,
            'supplier' => $inventory->supplier,
            'asset' => $inventory->asset
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
        return view('inventory.edit', [
            'inventory' => $inventory, 
            'devices' => Device::all(),
            'rooms' => Room::all(),
            'nomenclatures' => Nomenclature::all(),
        ]);
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
        $validated = $request->validate([
            'barcode' => 'required|max:255',
            'serial' => 'required|max:255',
            'device_id' => 'required|integer',
            // 'brand_id' => 'required|integer',
            'identity_id' => 'required|integer',
            'room_id' => 'required|integer',
            'resPic' => new RulesImageUpload
        ]);

        // dd($request->file());

        if ($validated) {
            $picture = $request->file('picture');

            // if ($picture != null) {
            //     $name = $picture->getClientOriginalName();
            //     $picture->move(public_path().'/images/', $name);
            // }

            $inventory->barcode = $request->barcode;
            $inventory->serial = $request->serial;
            $inventory->device_id = $request->device_id;
            // $inventory->brand_id = $request->brand_id;
            $inventory->identity_id = $request->identity_id;
            $inventory->room_id = $request->room_id;
            $inventory->price = $request->price;
            $inventory->year_purchased = $request->year_purchased;
            $inventory->supplier = $request->supplier;
            $inventory->penyusutan = $request->penyusutan;
            if ($picture) {
                $path = ($picture != null) ? Tenant::current()->domain.'/'.'picture_'.$inventory->id.'.'.$picture->guessExtension() : 'no_image.jpg';
                $inventory->picture = '/images/'.$path;
                $picture->move(public_path().'/images/'.Tenant::current()->domain.'/', 'picture_'.$inventory->id.'.'.$picture->guessExtension());
            }
            $inventory->update();

            return redirect()->route('inventory.show', ['id' => $inventory->id])->with('success', 'Entry Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->records()->delete();
        $inventory->conditions()->delete();

        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Entry Deleted!');
    }

    public function import(Request $request)
    {
        Excel::import(new InventoryImport, request()->file('fuck'));

        return redirect()->route('inventory.index')->with(['success', 'Entries Imported!']);
    }

    public function export(Request $request)
    {
        return Excel::download(new InventoryExport, 'inventory.xlsx');
    }

    // public function pdf()
    // {

    // }

    // public function bookletView()
    // {
    //     $inventories = Inventory::all();

    //     return view('pdf.booklet', ['inventories' => $inventories]);
    // }
  
    public function excel(Inventory $inventory)
    {
        return Excel::download(new InventoryDetailExport($inventory->id), 'inventory.xlsx');
    }

    public function raw(Request $request)
    {
        return Excel::download(new InventoryRawExport, 'inventory_raw.xlsx');
    }

    public function image(Request $request)
    {
        $failCount = array();
        $validated = $request->validate([
            'file' => new RulesImageUpload
        ]);

        if ($validated) {
            foreach($request->file('file') as $image)
            {
                $name = $image->getClientOriginalName();
                $record = Record::where('label', pathinfo($name, PATHINFO_FILENAME))->first();

                if ($record) {
                    if ($record->label == pathinfo($name, PATHINFO_FILENAME)) {
                        $inventory = Inventory::find($record->inventory_id);
                        $path = Tenant::current()->domain.'/'.'picture_'.$inventory->id.'.'.$image->guessExtension();
                        $inventory->picture = '/images/'.$path;
                        $image->move(public_path().'/images/'.Tenant::current()->domain, 'picture_'.$inventory->id.'.'.$image->guessExtension());  
                        $inventory->update();

                        // return back()->with(['success', 'Images Uploaded!']);
                    } else {
                        array_push($failCount, $name);
                    }
                } else {
                    array_push($failCount, $name);
                }
            }

            if (count($failCount) > 1) {
                return back()->with(['success', 'There are errors in file '.implode(', ', $failCount)]);
            } else {
                return back()->with(['success', 'Images uploaded!']);
            }
        }
    }

    public function paramIndex($parameter, $value)
    {
        switch ($parameter) {
            case 'brand':
                $inventory = Inventory::with('device', 'brand', 'identity', 'room', 'latest_condition', 'latest_record')
                    ->whereHas('identity.brand', function($query) use ($value) {
                        $query->where('id', $value);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
                break;
            
            case 'calibration_status':
                $inventory = Inventory::with('device', 'brand', 'identity', 'room', 'latest_condition', 'latest_record')
                    ->whereHas('latest_record', function($query) use ($value) {
                        $query->where('calibration_status',  $value);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
                break;

            case 'room':
                $inventory = Inventory::with('device', 'brand', 'identity', 'room', 'latest_condition', 'latest_record')
                    ->whereHas('room', function($query) use ($value) {
                        $query->where('id', $value);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
                break;

            case 'device':
                $inventory = Inventory::with('device', 'brand', 'identity', 'room', 'latest_condition', 'latest_record')
                    ->whereHas('device', function($query) use ($value) {
                        $query->where('id', $value);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
                break;
            
            default:
                $inventory = null;
                break;
        }

        return view('inventory.index', ['inventories' => $inventory]);  
    }

    public function search(Request $request)
    {
        $term = $request->search;
        $inventory = Inventory::with('device', 'brand', 'identity', 'room', 'latest_condition', 'latest_record','supplier')
            ->where('barcode', 'LIKE', '%'.$term.'%')
            ->orWhere('serial', 'LIKE', '%'.$term.'%')
            ->orWhereHas('latest_record', function($query) use ($term) {
                $query->where('label', 'LIKE', '%'.$term.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('inventory.index', ['inventories' => $inventory]);  
    }
}
