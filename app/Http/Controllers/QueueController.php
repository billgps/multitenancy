<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $queues = Queue::orderBy('created_at', 'desc')->paginate(15);

        return view('queue.index', ['queues' => $queues]);
    }

    public function logs(Queue $queue)
    {
        $logs = $queue->logs;

        return view('log.index', ['logs' => $logs]);
    }

    public function retry(Request $request)
    {
        $validated = $request->validate([
            'activity_id' => 'required|numeric',
            'tenant_id' => 'required|numeric',
            'payload' => 'required'
        ]);

        if ($validated) {
            Queue::create($validated);

            return redirect()->route('queue.index');
        }
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
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function show(Queue $queue)
    {
        $inventoriyIDs = array();
        foreach (json_decode($queue->payload) as $p) {
            array_push($inventoriyIDs, json_decode($p));
        }

        // $inventoriyIDs = implode(',', $inventoriyIDs);

        // opted for just showing the payload details
        // $tenantDB = $queue->tenant->database;
        // $query = "SELECT `id`, standard_name FROM ".$tenantDB.".inventories AS i WHERE `id` IN (".$inventoriyIDs.") INNER JOIN ".$tenantDB.".devices AS d ON d.id = i.device_id";
        // $inventories = DB::connection('tenant')->select($query);

        return view('queue.show', ['queue' => $queue, 'payload' => $inventoriyIDs]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function edit(Queue $queue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Queue $queue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Queue  $queue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Queue $queue)
    {
        $queue->logs()->delete();
        $payload = json_decode($queue->payload);
        $tenant = $queue->tenant->database;
        $ids = array();

        foreach ($payload as $p) {
            array_push($ids, json_decode($p)->inventory_id);
        }

        $query = "UPDATE ".$tenant.".inventories SET `aspak_code` = null WHERE `id` IN (".implode(',', $ids).")";
        DB::connection('tenant')->update($query);

        $queue->delete();

        return response(['message' => "successfully deleted", 200]);
    }
}
