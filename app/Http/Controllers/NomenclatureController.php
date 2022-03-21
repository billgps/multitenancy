<?php

namespace App\Http\Controllers;

use App\Models\Nomenclature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;

class NomenclatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nomenclatures = Nomenclature::all();

        return view('nomenclatures.index', ['nomenclatures' => $nomenclatures]);
    }

    public function addKeyword(Request $request, Nomenclature $nomenclature)
    {
        $currenyKeywords = $nomenclature->keywords;
        $newKeywords = $currenyKeywords.$request->standard_name.';';

        try {
            $nomenclature->update(
                ['keywords' => $newKeywords]
            );
    
            return response(['msg' => 'successfully added to keywords'], 200);
        } catch (\Throwable $th) {
            return response(['err' => $th], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nomenclatures.create');
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
            'standard_name' => 'required|string|max:255|unique:host.nomenclatures,standard_name',
            'risk_level' => 'required|numeric',
            'aspak_code' => 'required|unique:host.nomenclatures,aspak_code',
            'keywords' => 'string'
        ]);

        if ($validated) {
            $nomenclature = new Nomenclature();
            $nomenclature->create($validated);

            return redirect()->route('nomenclature.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nomenclature  $nomenclature
     * @return \Illuminate\Http\Response
     */
    public function show(Nomenclature $nomenclature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nomenclature  $nomenclature
     * @return \Illuminate\Http\Response
     */
    public function edit(Nomenclature $nomenclature)
    {
        return view('nomenclatures.edit', ['nomenclature' => $nomenclature]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nomenclature  $nomenclature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nomenclature $nomenclature)
    {
        $validated = $request->validate([
            'standard_name' => 'required|string|max:255',
            'risk_level' => 'required|numeric',
            'aspak_code' => 'required',
            'keywords' => 'string'
        ]);

        if ($validated) {
            $nomenclature->update($validated);

            return redirect()->route('nomenclature.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nomenclature  $nomenclature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nomenclature $nomenclature)
    {
        //
    }
}
