<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\Inventory;
use App\Models\Response;
use App\Models\User;
use App\Notifications\ResponseUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use DB;

use App\Rules\ImageUpload as RulesImageUpload;
use Doctrine\Inflector\Rules\English\Rules;
use Spatie\Multitenancy\Models\Tenant;

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
        $invs = Inventory::all();
        return view('response.create', ['complain' => $complain, 'invs' => $invs]);
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
            'status' => 'required',
            // 'description' => 'max:255',
            'resPic' => new RulesImageUpload
        ]);

        $latest_id = Response::max('id');
        if ($validated) {
            $resPic = $request->file('resPic');

            $response = new Response();
            $response->complain_id = $request->complain_id;
            $response->user_id = $request->user_id;
            $response->progress_status = $request->progress_status;
            $response->barcode = $request->barcode;
            $response->status = $request->status;
            $response->description = $request->description;
            if ($resPic) {                
                $path = ($resPic != null) ? Tenant::current()->domain.'/'.'resPic_'.($latest_id + 1).'.'.$resPic->getClientOriginalExtension() : 'no_image.jpg';
                $response->resPic = '/images/resPic'.$path;
                $resPic->move(public_path().'/images/'.Tenant::current()->domain.'/responses/', 'resPic_'.($latest_id + 1).'.'.$resPic->getClientOriginalExtension());
            }
        }
            $response->save();

            $user = User::find($response->complain->user_id);

            Notification::send($user, new ResponseUpdate($response));

            return redirect()->route('complain.show', ['id' => $request->complain_id])->with('success', 'New Entry Added');
        
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
            'resPic' => new RulesImageUpload


        ]);

        if ($validated) {
            $resPic = $request->file('resPic');
            $response->complain_id = $request->complain_id;
            $response->user_id = $request->user_id;
            $response->progress_status = $request->progress_status;
            $response->description = $request->description;
            $response->serialnumber = $request->serialnumber;
            $response->status = $request->status;
            $response->created_at = date('Y-m-d H:i:s');
            $response->updated_at = date('Y-m-d H:i:s');

            DB::table('responses')->where('complain_id', $response->complain_id)->update([
                'user_id' => $response->user_id,
                'progress_status' => $response->progress_status,
                'description' => $response->description,
                'serialnumber' => $response->serialnumber,
                'status' => $response->status,
                'created_at' => $response->created_at,
                'updated_at' => $response->updated_at
            ]);
            
            if ($resPic) {
                $path = ($resPic != null) ? Tenant::current()->domain.'/'.'resPic_'.$response->id.'.'.$resPic->getClientOriginalExtension() : 'no_image.jpg';
                $response->resPic = '/images/'.$path;
                $resPic->move(public_path().'/images/'.Tenant::current()->domain.'/', 'resPic_'.$response->id.'.'.$resPic->getClientOriginalExtension());
                
                DB::table('responses')->where('complain_id', $response->complain_id)->update([
                    'resPic' => $response->resPic
                ]);
            };

        }
            $user = User::find($response->user_id);

            Notification::send($user, new ResponseUpdate($response));

            return redirect()->route('complain.show', ['id' => $request->complain_id])->with('success', 'New Entry Added');
        
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
