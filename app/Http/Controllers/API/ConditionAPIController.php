<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConditionResource;
use App\Models\Condition;
use Illuminate\Http\Request;

class ConditionAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conditions = Condition::all();

        return response()->json(ConditionResource::collection($conditions), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function show(Condition $condition)
    {
        return response()->json(new ConditionResource($condition), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function edit(Condition $condition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Condition $condition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Condition $condition)
    {
        //
    }
}
