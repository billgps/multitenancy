<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use Illuminate\Http\Request;
use App\Http\Resources\ConsumableResource;

class ConsumableAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consumables = Consumable::with('inventory', 'inventory.device')->get();

        return response()->json(ConsumableResource::collection($consumables), 200);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consumable  $consumable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consumable $consumable)
    {
        //
    }
}
