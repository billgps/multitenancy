<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Imports\IdentityImport;
use App\Models\Brand;
use App\Models\Device;
use App\Models\Identity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Multitenancy\Models\Tenant;

class IdentityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $identities = Identity::with('device', 'brand')->get();

        return view('identity.index', ['identities' => $identities]);
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

        return view('identity.create', [
            'devices' => $devices,
            'brands' => $brands,
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
            'device_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'model' => 'required|string|max:255',
        ]);

        if ($validated) {
            $manual = $request->file('manual');
            $procedure = $request->file('procedure');

            if ($manual != null) {
                $manualName = $manual->getClientOriginalName();
                $manual->move(public_path().'/module/'.Tenant::current()->domain.'/', $manualName);
                $manualPath = '/module/'.Tenant::current()->domain.'/'.$manualName;
            }

            if ($procedure != null) {
                $procedureName = $procedure->getClientOriginalName();
                $procedure->move(public_path().'/procedure/'.Tenant::current()->domain.'/', $procedureName);
                $procedurePath = '/procedure/'.Tenant::current()->domain.'/'.$procedureName;
            }

            $identity = new Identity();
            $identity->device_id = $request->device_id;
            $identity->brand_id = $request->brand_id;
            $identity->model = $request->model;
            $identity->manual = ($manual != null) ? $manualPath : null;
            $identity->procedure = ($procedure != null) ? $procedurePath : null;
            $identity->save();

            if ($request->redirect != null) {
                return back()->with('success', 'New Entry Added');
            } else {
                return redirect()->route('identity.index')->with('success', 'New Entry Added');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Identity  $identity
     * @return \Illuminate\Http\Response
     */
    public function show(Identity $identity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Identity  $identity
     * @return \Illuminate\Http\Response
     */
    public function edit(Identity $identity)
    {
        $brands = Brand::all();
        $devices = Device::all();

        return view('identity.edit', [
            'identity' => $identity,
            'brands' => $brands, 
            'devices' => $devices
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Identity  $identity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Identity $identity)
    {
        $validated = $request->validate([
            'device_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'model' => 'required|string|max:255',
        ]);

        if ($validated) {
            $manual = $request->file('manual');
            $procedure = $request->file('procedure');

            // if ($manual != null) {
            //     $manualName = $manual->getClientOriginalName();
            //     $manual->move(public_path().'/module/', $manualName);
            // }

            // if ($procedure != null) {
            //     $procedureName = $procedure->getClientOriginalName();
            //     $procedure->move(public_path().'/procedure/', $procedureName);
            // }

            $identity->device_id = $request->device_id;
            $identity->brand_id = $request->brand_id;
            $identity->model = $request->model;
            if ($manual) {
                $manualName = $manual->getClientOriginalName();
                $manual->move(public_path().'/module/'.Tenant::current()->domain.'/', $manualName);
                $manualPath = '/module/'.Tenant::current()->domain.'/'.$manualName;
                $identity->manual = $manualPath;
            }
            if ($procedure) {
                $procedureName = $procedure->getClientOriginalName();
                $procedure->move(public_path().'/procedure/'.Tenant::current()->domain.'/', $procedureName);
                $procedurePath = '/procedure/'.Tenant::current()->domain.'/'.$procedureName;
                $identity->procedure = $procedurePath;
            }
            $identity->update();

            return redirect()->route('identity.index')->with('success', 'New Entry Added');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Identity  $identity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Identity $identity)
    {
        //
    }

    public function import()
    {
        Excel::import(new IdentityImport, request()->file('file'));

        return redirect()-> route('identity.index')->with('success', 'Data Imported');
    }

    public function manualDownload (Identity $identity)
    {
        // dd($path);
        if ($identity->manual != null) {
            try {
                $path = public_path().$identity->manual;

                return response()->download($path, $identity->manual);
            } catch (\Throwable $th) {
                Log::error('Manual cannot be downloaded', ['id' => $identity->id]);

                return back()->with('error', 'Something went wrong');
            }
        } else {
            // $path = public_path().'/report/'.Tenant::current()->domain.'/'.$record->report;
            // if (file_exists($path)) {
            //     return response()->download($path, $record->report);
            // } else {
                return back()->with('error', 'File does not exist');
            // }
        }
    }

    public function procedureDownload (Identity $identity)
    {
        // dd($path);
        if ($identity->procedure != null) {
            try {
                $path = public_path().$identity->procedure;

                return response()->download($path, $identity->procedure);
            } catch (\Throwable $th) {
                Log::error('Procedure cannot be downloaded', ['id' => $identity->id]);

                return back()->with('error', 'Something went wrong');
            }
        } else {
            // $path = public_path().'/report/'.Tenant::current()->domain.'/'.$record->report;
            // if (file_exists($path)) {
            //     return response()->download($path, $record->report);
            // } else {
                return back()->with('error', 'File does not exist');
            // }
        }
    }

    public function ajax(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $identities = Identity::with('brand')->where('device_id', $id)->get();
        }

        return response()->json(['data' => $identities], 200);
    }
}
