<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('adminsitrator.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenant-create');
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
            'name' => 'required|max:255',
            'code' => 'required',
            'public_code' => 'required',
            'address' => 'required',
            'database' => 'required',
            'domain' => 'required',
        ]);

        if ($validated) {
            $picture = $request->file('vendor_id');
            if ($picture != null) {
                $label = $picture->getClientOriginalName();
                $picture->move(public_path(), $picture->getClientOriginalName());
            } else {
                $label = 'gps_logo.png';
            }

            $tenant = new Tenant();
            $tenant->name = $request->name;
            $tenant->code = $request->code;
            $tenant->public_code = $request->public_code;
            $tenant->address = $request->address;
            $tenant->database = $request->database;
            $tenant->domain = $request->domain.'.'.substr(env('APP_URL'), 7);
            $tenant->vendor_id = $label;
            $tenant->save();
    
            return redirect()->route('administrator.dashboard');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function show(Tenant $tenant)
    {
        return view('tenant-show', ['tenant' => $tenant]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tenant $tenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return back()->with('success', 'Tenant Deleted');
    }
}
