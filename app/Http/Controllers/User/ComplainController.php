<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\Response;
use App\Models\Room;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complains = Complain::with('response', 'response.user',  'user', 'room')->orderBy('created_at', 'desc')->get();

        return view('complain.index', ['complains' => $complains]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = Room::all();

        return view('complain.create', ['rooms' => $rooms]);
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
            'room_id' => 'required|integer',
            'user_id' => 'required|integer',
            'date_time' => 'required|date',
            // 'description' => 'max:255',
        ]);

        if ($validated) {
            $complain = new Complain();
            $complain->room_id = $request->room_id;
            $complain->user_id = $request->user_id;
            $complain->date_time = $request->date_time;
            $complain->description = $request->description;
            $complain->save();

            return redirect()->route('complain.index')->with('success', 'New Entry Added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $complain = Complain::with('user', 'response', 'response.user', 'room')->find($id);

        return view('complain.show', ['complain' => $complain]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function edit(Complain $complain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complain $complain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complain $complain)
    {
        $complain->response()->delete();
        $complain->delete();

        return redirect()->route('complain.index')->with('success', 'Entry Deleted!');
    }
}
