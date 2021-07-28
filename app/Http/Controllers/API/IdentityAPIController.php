<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\IdentityResource;
use App\Models\Identity;
use Illuminate\Http\Request;

class IdentityAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $identities = Identity::with('device', 'brand')->get();

        return response()->json(IdentityResource::collection($identities), 200);
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
        //
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
        //
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
}
