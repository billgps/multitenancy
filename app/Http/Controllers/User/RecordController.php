<?php

namespace App\Http\Controllers\User;

use App\Exports\RecordExport;
use App\Http\Controllers\Controller;
use App\Imports\RecordImport;
use App\Models\Activity;
use App\Models\Inventory;
use App\Models\Record;
use Illuminate\Http\Request;
use App\Rules\ImageUpload as RulesImageUpload;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Multitenancy\Models\Tenant;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $abc = Inventory::get()->chunk(10);

        // dd($abc);

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
                $report->move(public_path().'/report/'.Tenant::current()->domain, $request->label.'L.'.$report->guessExtension());  
            } else {
                $reportName = 'Belum Update';
            }

            if ($certificate != null) {
                $certificateName = $certificate->getClientOriginalName();
                $certificate->move(public_path().'/certificate/'.Tenant::current()->domain, $request->label.'C.'.$certificate->guessExtension());  
            } else {
                $certificateName = 'Belum Update';
            }

            $record = new Record();
            $record->cal_date = $request->cal_date;
            $record->label = $request->label;
            $record->calibration_status = $request->calibration_status;
            $record->result = $request->result;
            $record->activity_id = Tenant::current()->is_aspak ? Activity::active()->id : null;
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
            'label' => 'required|max:255|unique:records,label,'.$record->id,
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
                $record->report = $request->label.'L.'.$report->guessExtension();
                $report->move(public_path().'/report/'.Tenant::current()->domain, $record->label.'L.'.$report->guessExtension());  
            }
            if ($certificate) {
                $record->certificate = $request->label.'C.'.$certificate->guessExtension();
                $certificate->move(public_path().'/certificate/'.Tenant::current()->domain, $record->label.'C.'.$certificate->guessExtension());  
            }
            $record->update();

            return redirect()->route('record.index')->with('success', 'Entry Updated');
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

    public function export(Request $request)
    { 
        return Excel::download(new RecordExport, 'record.xlsx');
    }

    public function reportDownload (Record $record)
    {
        $path = public_path().'/report/'.Tenant::current()->domain.'/'.$record->report;
        if ($record->report != null) {
            if (file_exists($path)) {
                return response()->download($path, $record->report);
            } else {
                return back()->with('error', 'Something wrong');
            }
        } else {
            return back()->with('error', 'File does not exist');
        }
    }

    public function reportUpload (Request $request)
    {
        $failCount = array();
        $validated = $request->validate([
            'report' => 'required'
        ]);

        if ($validated) {
            foreach($request->file('report') as $report)
            {
                $name = $report->getClientOriginalName();

                $record = Record::where('label', pathinfo($name, PATHINFO_FILENAME))->first();

                if ($record) {
                    if ($record->label == pathinfo($name, PATHINFO_FILENAME)) {
                        $record->report = $record->label.'L.'.$report->guessExtension();
                        $report->move(public_path().'/report/'.Tenant::current()->domain, $record->label.'L.'.$report->guessExtension());  
                        $record->update();

                        // return back()->with(['success', 'Images Uploaded!']);
                    } else {
                        array_push($failCount, $name);
                    }
                } else {
                    array_push($failCount, $name);
                }
            }

            if (count($failCount) > 0) {
                return back()->with('error', 'There are errors in file '.implode(', ', $failCount));
            } else {
                return back()->with('success', 'Reports uploaded!');
            }
        }
    }

    public function certificateDownload (Record $record)
    {
        $path = public_path().'/certificate/'.Tenant::current()->domain.'/'.$record->certificate;
        // dd($path);
        if ($record->certificate != null) {
            if (file_exists($path)) {
                return response()->download($path, $record->certificate);
            } else {
                return back()->with('error', 'Something wrong');
            }
        } else {
            return back()->with('error', 'File does not exist');
        }
    }

    public function certificateUpload (Request $request)
    {
        $failCount = array();
        $validated = $request->validate([
            'certificate' => 'required'
        ]);

        if ($validated) {
            foreach($request->file('certificate') as $certificate)
            {
                $name = $certificate->getClientOriginalName();

                $record = Record::where('label', pathinfo($name, PATHINFO_FILENAME))->first();

                if ($record) {
                    if ($record->label == pathinfo($name, PATHINFO_FILENAME)) {
                        $record->certificate = $record->label.'C.'.$certificate->guessExtension();
                        $certificate->move(public_path().'/certificate/'.Tenant::current()->domain, $record->label.'C.'.$certificate->guessExtension());  
                        $record->update();

                        // return back()->with(['success', 'Images Uploaded!']);
                    } else {
                        array_push($failCount, $name);
                    }
                } else {
                    array_push($failCount, $name);
                }
            }

            if (count($failCount) > 0) {
                return back()->with('error', 'There are errors in file '.implode(', ', $failCount));
            } else {
                return back()->with('success', 'Certificates uploaded!');
            }
        }
    }

    public function paramIndex ($param)
    {
        $records = Record::with('inventory', 'inventory.device')->where('result', str_replace('_', ' ', $param))->get();

        return view('record.index', ['records' => $records]);  
    }
}
