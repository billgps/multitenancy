<?php

namespace App\Http\Controllers\User;

use App\Exports\DeviceExport;
use App\Http\Controllers\Controller;
use App\Imports\DeviceImport;
use App\Models\Device;
use App\Models\Nomenclature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Svg\Tag\Rect;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $device = Device::with('inventories')->orderBy('created_at', 'desc')->get();

        return view('device.index', ['devices' => $device]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('device.create', ['nomenclatures' => Nomenclature::all()]);
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
            'standard_name' => 'required|max:255',
            'nomenclature_id' => 'required|numeric'
        ]);

        if ($validated) {
            $device = new Device();
            $device->standard_name = $request->standard_name;
            $device->nomenclature_id = $request->nomenclature_id;
            $device->save();

            if ($request->modal) {
                return back()->with('success', 'New Entry Added');
            } else {
                return redirect()->route('device.show', ['id' => $device->id])->with('success', 'New Entry Added');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $device = Device::with('inventories', 'inventories.latest_record', 'inventories.room')->find($id);

        return view('device.show', ['device' => $device, 'inventories' => $device->inventories]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        return view('device.edit', ['device' => $device, 'nomenclatures' => Nomenclature::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'standard_name' => 'required|max:255',
            'nomenclature_id' => 'required|numeric'
        ]);

        if ($validated) {
            DB::connection('host')->update('UPDATE nomenclatures SET keywords = CONCAT(COALESCE(keywords, ""), ";'.$request->standard_name.'") WHERE id = '.$request->nomenclature_id);   
            $device->standard_name = $request->standard_name;
            $device->nomenclature_id = $request->nomenclature_id;
            $device->update();

            return redirect()->route('device.show', ['id' => $device->id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()->route('device.index');
    }

    public function import(Request $request)
    {
        $devices = Excel::toArray(new DeviceImport, request()->file('file'));
        foreach ($devices[0] as $key => $value) {
            $result = DB::connection('host')->select('SELECT * FROM nomenclatures WHERE 
            MATCH(`standard_name`,  `keywords`) AGAINST ("'.$value['nama_alat'].'" 
            IN BOOLEAN MODE) > 3');

            if (count($result) > 1 || count($result) < 1) {
                $devices[0][$key]['nomenclature_id'] = null;
            } else {
                $devices[0][$key]['nomenclature_id'] = $result[0];
            }
        }

        $nomenclatures = Nomenclature::all();

        return view('device.map', ['devices' => $devices[0], 'nomenclatures' => $nomenclatures]);
    }

    public function mapped(Request $request)
    {
        // validation cant go back because device.map is a return from a post method
        // not a get << need to be revised >>

        // $validated = $request->validate([
        //     'nomenclature_id.*' => 'required|numeric',
        //     'standard_name' => 'required|string|distinct|unique:devices'
        // ]);

        foreach ($request->isNewKeyword as $key => $value) {
            if ($value == 1) {
                DB::connection('host')->update('UPDATE nomenclatures SET keywords = CONCAT(COALESCE(keywords, ""), ";'.$request->standard_name[$key].'") WHERE id = '.$request->nomenclature_id[$key]);   
            }
        }

        foreach ($request->standard_name as $key => $value) {
            $device = new Device();
            $device->create([
                'standard_name' => $value,
                'nomenclature_id' => $request->nomenclature_id[$key] == 'null' ? null : $request->nomenclature_id[$key]
            ]);
        }

        return redirect()->route('device.index');
    }

    public function export(Request $request)
    { 
        return Excel::download(new DeviceExport, 'device.xlsx');
    }
}
