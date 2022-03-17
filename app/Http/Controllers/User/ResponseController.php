<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\Response;
use App\Models\User;
use App\Notifications\ResponseUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Response::all();

        return view('response.index', ['responses' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Complain $complain)
    {
        return view('response.create', ['complain' => $complain]);
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
            'complain_id' => 'required|integer',
            'user_id' => 'required|integer',
            'progress_status' => 'required',
            // 'description' => 'max:255',
        ]);

        if ($validated) {
            $response = new Response();
            $response->complain_id = $request->complain_id;
            $response->user_id = $request->user_id;
            $response->progress_status = $request->progress_status;
            $response->description = $request->description;
            $response->save();

            $user = User::find($response->complain->user_id);

            Notification::send($user, new ResponseUpdate($response));

            return redirect()->route('complain.show', ['id' => $request->complain_id])->with('success', 'New Entry Added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function edit(Response $response)
    {
        return view('response.edit', ['response' => $response]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Response $response)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'progress_status' => 'required',
            // 'description' => 'max:255',
        ]);

        if ($validated) {
            $response->user_id = $request->user_id;
            $response->progress_status = $request->progress_status;
            $response->description = $request->description;
            $response->update();

            $user = User::find($response->complain->user_id);

            Notification::send($user, new ResponseUpdate($response));

            return redirect()->route('complain.show', ['id' => $request->complain_id])->with('success', 'New Entry Added');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function destroy(Response $response)
    {
        //
    }
}
