<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Record;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Spatie\Multitenancy\Models\Tenant;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active = Activity::where('is_active', true)->first();
        $history = Activity::where('is_active', false)->get();

        return view('activity.index', ['active' => $active, 'history' => $history]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('activity.create');
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
            'started_at' => 'date',
            'order_no' => 'required|string|max:255',
            'finished_at' => 'date',
            'active_at' => 'required|numeric',
            'status' => 'required|in:on going,finished,queued,on hold'
        ]);

        $client = new Client([
            'base_uri' => 'http://aspak.kemkes.go.id/monitoring/gps/'
        ]);

        $token = 'xcdfae';
        // dd(Tenant::current()->public_code);

        if ($validated) {
            if ($request->active_at == date('Y')) {
                $is_active = true;
            } else {
                $is_active = false;
            }

            $response = $client->request('POST', 'create?ipid=IP3173002', [
                'headers'=> [
                    'Authorization' => 'Bearer '.$token,        
                    'Accept'        => 'application/json'
                ],
                'form_params' => [
                    'Data[no]' => $request->order_no,
                    'Data[tgl]' => $request->started_at,
                    'Data[faskes]' => Tenant::current()->public_code
                ]
            ]);
    
            $content = json_decode($response->getBody()->getContents());

            if ($content->success) {
                $activity = Activity::create([
                    'order_no' => $request->order_no,
                    'aspak_id' => $content->data->id,
                    'started_at' => $request->started_at,
                    'finished_at' => $request->finished_at,
                    'active_at' => intVal($request->active_at),
                    'status' => $request->status,
                    'is_active' => $is_active
                ]);
    
                $query = "UPDATE records SET `activity_id`=".$activity->id." WHERE YEAR (`cal_date`) = ".$request->active_at;
                DB::update($query);
    
                return redirect()->route('activity.index');
            } else {
                return back()->with('error', $content->msg);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
