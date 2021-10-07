<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecordResource;
use App\Models\Record;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Tenant;

class RecordAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Record::all();

        return response()->json(RecordResource::collection($records), 200);
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
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }

    public function certificateDownload(Record $record)
    {
        $header = array(
            'Content-Type: application/pdf',
        );
        $path = public_path().'/certificate/'.Tenant::current()->domain.'/'.$record->certificate;
        if ($record->certificate != null) {
            if (file_exists($path)) {
                return response()->download($path, $record->certificate, $header);
            } else {
                return response('Something went wrong...', 500);
            }
        } else {
            return response('File not found', 404);
        }
    }

    public function reportDownload(Record $record)
    {
        $header = array(
            'Content-Type: application/pdf',
        );
        $path = public_path().'/report/'.Tenant::current()->domain.'/'.$record->report;
        if ($record->report != null) {
            if (file_exists($path)) {
                return response()->download($path, $record->report, $header);
            } else {
                return response('Something went wrong...', 500);
            }
        } else {
            return response('File not found', 404);
        }
    }
}
