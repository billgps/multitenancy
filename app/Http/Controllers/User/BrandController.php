<?php

namespace App\Http\Controllers\User;

use App\Exports\BrandExport;
use App\Http\Controllers\Controller;
use App\Imports\BrandImport;
use App\Models\Brand;
use App\Models\Identity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::get();

        return view('brand.index', ['brands' => $brands]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brand.create');
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
            'brand' => 'required|max:255',
            'origin' => 'required|max:255',
        ]);

        if ($validated) {
            $brand = new Brand();
            $brand->brand = $request->brand;
            $brand->origin = $request->origin;
            $brand->save();

            if ($request->modal) {
                return back()->with('success', 'New Entry Added');
            } else {
                return redirect()->route('brand.index')->with('success', 'New Entry Added');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::find($id);

        return view('brand.show', ['brand' => $brand]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('brand.edit', ['brand' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'brand' => 'required|max:255',
            'origin' => 'required|max:255',
        ]);

        if ($validated) {
            $brand->brand = $request->brand;
            $brand->origin = $request->origin;
            $brand->update();

            return redirect()->route('brand.show', ['id' => $brand->id])->with('success', 'Entry Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brand.index');
    }

    public function import()
    {
        Excel::import(new BrandImport, request()->file('file'));

        return redirect()->route('brand.index')->with('success', 'Data Imported');
    }

    public function export(Request $request)
    { 
        return Excel::download(new BrandExport, 'brand.xlsx');
    }

    public function ajax(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $identities = Identity::with('brand')->where('device_id', $id)->groupBy('brand_id')->get();
        }

        return response()->json(['data' => $identities], 200);
    }
}
