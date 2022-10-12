<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Imports\ConditionImport;
use App\Models\Condition;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\ImageUpload as RulesImageUpload;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\DB;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conditions = Condition::with('inventory', 'inventory.device')->get();

        return view('condition.index', ['conditions' => $conditions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Inventory $inventory = null)
    {
        if ($inventory) {
            return view('condition.create', ['inventory' => $inventory]);
        } else {            
            return view('condition.create', ['inventories' => Inventory::with('device')->get()]);
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
            'user_id' => 'required|integer',
            'event' => 'required',
            'event_date' => 'required|date',
            'status' => 'required',
            'inventory_id' => 'required|integer',
        ]);
        
        

        if ($validated) {
            $worksheet = $request->file('worksheet');
            // $worksheetName = 'Belum Diupload';

            // if ($worksheet != null) {
            //     $worksheetName = $worksheet->getClientOriginalName();
            //     $worksheet->move(public_path().'/worksheet/', $worksheetName);
            // }

            $condition = new Condition();

            $condition->event_date = $request->event_date;
            $condition->event = $request->event;
            $condition->status = $request->status;
            $condition->user_id = $request->user_id;
            if ($worksheet) {
                $condition->worksheet = ($worksheet != null) ? time().'_LK.'.$worksheet->guessExtension() : 'Belum Update';
                $worksheet->move(public_path().'/worksheets/'.Tenant::current()->domain.'/', time().'_LK.'.$worksheet->guessExtension());
            }
            $condition->inventory_id = $request->inventory_id;
            $condition->save();

            return redirect()->route('condition.index')->with('success', 'New Entry Added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function show(Condition $condition)
    {
        return view('condition.show', [
            'condition' => $condition, 
            'inventory' => $condition->inventory,
            'user' => $condition->user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function edit(Condition $condition)
    {
        return view('condition.edit', [
            'condition' => $condition, 
            'inventories' => Inventory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Condition $condition)
    {
        $validated = $request->validate([
            'event' => 'required',
            'event_date' => 'required|date',
            'status' => 'required',
            'inventory_id' => 'required|integer',
        ]);
        
        if ($validated) {
            $worksheet = $request->file('worksheet');
            // $worksheetName = 'Belum Diupload';

            // if ($worksheet != null) {
            //     $worksheetName = $worksheet->getClientOriginalName();
            //     $worksheet->move(public_path().'/worksheet/', $worksheetName);
            // }

            $condition->event_date = $request->event_date;
            $condition->event = $request->event;
            $condition->status = $request->status;
            $condition->inventory_id = $request->inventory_id;
            if ($worksheet) {
                $condition->worksheet = 'updated_'.time().'_'.$condition->id.'_LK.'.$worksheet->guessExtension();
                $worksheet->move(public_path().'/worksheets/'.Tenant::current()->domain.'/', 'updated_'.time().'_'.$condition->id.'_LK.'.$worksheet->guessExtension());
            } else {
                $condition->worksheet = 'Belum Update';
            }
            $condition->update();

            return redirect()->route('condition.show', ['condition' => $condition->id])->with('success', 'Entry Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Condition $condition)
    {
        $condition->delete();

        return redirect()->route('condition.index');
    }

    public function import()
    {
        Excel::import(new ConditionImport, request()->file('file'));

        return redirect()->route('condition.index')->with(['success', 'Data Imported!']);
    }

    public function worksheetDownload (Condition $condition)
    {
        $path = public_path().'/worksheets/'.Tenant::current()->domain.'/'.$condition->worksheet;
        if ($condition->worksheet != null) {
            if (file_exists($path)) {
                return response()->download($path, $condition->worksheet);
            } else {
                return back()->with('error', 'Something wrong');
            }
        } else {
            return back()->with('error', 'File does not exist');
        }
    }

    public function worksheetUpload (Request $request)
    {
        $failCount = array();
        $validated = $request->validate([
            'file' => new RulesImageUpload
        ]);

        if ($validated) {
            foreach($request->file('file') as $certificate)
            {
                $name = $certificate->getClientOriginalName();
                $certificate->move(public_path().'/report/', $name);  

                $condition = Condition::where('id', pathinfo($name, PATHINFO_FILENAME))->first();

                if ($condition) {
                    $condition->worksheet = $name;
                    $condition->update();

                    return back()->with(['success', 'Reports Uploaded']);
                } else {
                    array_push($failCount, $name);
                }
            }

            return back()->with(['success', 'There are errors in file '.implode(', ', $failCount)]);
        }
    }

    public function parameterIndex ($param)
    {
        $conditions = Condition::with('inventory', 'inventory.device')->where('status', $param)->get();

        return view('condition.index', ['conditions' => $conditions]);
    }
}
