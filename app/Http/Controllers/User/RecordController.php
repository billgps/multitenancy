<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Imports\RecordImport;
use App\Models\Inventory;
use App\Models\Record;
use Illuminate\Http\Request;
use App\Rules\ImageUpload as RulesImageUpload;
use Maatwebsite\Excel\Facades\Excel;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Record::with('inventory', 'inventory.device')->get();

        return view('record.index', ['records' => $records]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Inventory $inventory = null)
    {
        if ($inventory) {
            return view('record.create', ['inventory' => $inventory]);
        } else {            
            return view('record.create', ['inventories' => Inventory::with('device')->get()]);
        }
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
            'cal_date' => 'required|date',
            'label' => 'required|unique:records|max:255',
            'calibration_status' => 'required',
            'result' => 'required',
            'inventory_id' => 'required|integer',
        ]);

        if ($validated) {
            $report = $request->file('report');
            $certificate = $request->file('certificate');

            if ($report != null) {
                $reportName = $report->getClientOriginalName();
                $report->move(public_path().'/report/', $reportName);
            } else {
                $reportName = 'Belum Update';
            }

            if ($certificate != null) {
                $certificateName = $certificate->getClientOriginalName();
                $certificate->move(public_path().'/certificate/', $certificateName);
            } else {
                $certificateName = 'Belum Update';
            }

            $record = new Record();
            $record->cal_date = $request->cal_date;
            $record->label = $request->label;
            $record->calibration_status = $request->calibration_status;
            $record->result = $request->result;
            $record->certificate = $certificateName;
            $record->report = $reportName;
            $record->vendor = 'PT Global Promedika Services';
            $record->inventory_id = $request->inventory_id;
            $record->save();

            return redirect()->route('record.index')->with('success', 'New Entry Added');
        }
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
        return view('record.edit', [
            'record' => $record, 
            'inventories' => Inventory::all()
        ]);
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
        $validated = $request->validate([
            'cal_date' => 'required|date',
            'label' => 'required|unique:records|max:255',
            'calibration_status' => 'required',
            'result' => 'required',
            'inventory_id' => 'required|integer',
        ]);

        if ($validated) {
            $report = $request->file('report');
            $certificate = $request->file('certificate');

            // if ($report != null) {
            //     $reportName = $report->getClientOriginalName();
            //     $report->move(public_path().'/report/', $reportName);
            // } else {
            //     $reportName = 'Belum Update';
            // }

            // if ($certificate != null) {
            //     $certificateName = $certificate->getClientOriginalName();
            //     $certificate->move(public_path().'/certificate/', $certificateName);
            // } else {
            //     $certificateName = 'Belum Update';
            // }

            $record->cal_date = $request->cal_date;
            $record->label = $request->label;
            $record->calibration_status = $request->calibration_status;
            $record->result = $request->result;
            $record->vendor = 'PT Global Promedika Services';
            $record->inventory_id = $request->inventory_id;
            if ($report) {
                $report->move(public_path().'/report/', $report->getClientOriginalName());
            }
            if ($certificate) {
                $certificate->move(public_path().'/certificate/', $certificate->getClientOriginalName());
            }
            $record->update();

            return redirect()->route('record.index')->with('success', 'New Entry Added');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        $record->delete();

        return redirect()->route('record.index');
    }

    public function import()
    {
        Excel::import(new RecordImport, request()->file('file'));

        return redirect()->route('record.index');
    }

    public function reportDownload (Record $record)
    {
        $path = public_path().'/report/'.$record->label.'.pdf';
        if (file_exists($path)) {
            return response()->download($path, $record->label.'L.pdf');
        } else {
            $path = public_path().'/report/'.$record->report;
            if (file_exists($path)) {
                return response()->download($path, $record->label.'L.pdf');
            } else {
                return back()->with(['error', 'File does not exist']);
            }
        }
    }

    public function reportUpload (Request $request)
    {
        $failCount = array();
        $validated = $request->validate([
            'file' => new RulesImageUpload
        ]);

        if ($validated) {
            foreach($request->file('file') as $report)
            {
                $name = $report->getClientOriginalName();
                $report->move(public_path().'/report/', $name);  

                $record = Record::where('label', pathinfo($name, PATHINFO_FILENAME))->first();

                if ($record) {
                    $record->report = $name;
                    $record->update();

                    return back()->with(['success', 'Reports Uploaded']);
                } else {
                    array_push($failCount, $name);
                }
            }

            return back()->with(['success', 'There are errors in file '.implode(', ', $failCount)]);
        }
    }

    public function certificateDownload (Record $record)
    {
        $path = public_path().'/certificate/'.$record->label.'.pdf';
        if (file_exists($path)) {
            return response()->download($path, $record->label.'C.pdf');
        } else {
            $path = public_path().'/certificate/'.$record->certificate;
            if (file_exists($path)) {
                return response()->download($path, $record->label.'C.pdf');
            } else {
                return back()->with(['error', 'File does not exist']);
            }
        }
    }

    public function certificateUpload (Request $request)
    {
        $failCount = array();
        $validated = $request->validate([
            'file' => new RulesImageUpload
        ]);

        if ($validated) {
            foreach($request->file('file') as $certificate)
            {
                $name = $certificate->getClientOriginalName();
                $certificate->move(public_path().'/certificate/', $name);  

                $record = Record::where('label', pathinfo($name, PATHINFO_FILENAME))->first();

                if ($record) {
                    $record->certificate = $name;
                    $record->update();

                    return back()->with(['success', 'Certificates Uploaded']);
                } else {
                    array_push($failCount, $name);
                }
            }

            return back()->with(['success', 'There are errors in file '.implode(', ', $failCount)]);
        }
    }
}