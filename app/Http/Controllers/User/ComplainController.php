<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\Inventory;
use App\Models\Response;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Rules\ImageUpload as RulesImageUpload;
use Spatie\Multitenancy\Models\Tenant;
use PDF;

class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff') || Auth::user()->hasRole('nurse')) {
            $complains = Complain::with('response', 'response.user',  'user', 'room')->orderBy('created_at', 'desc')->get();
        } else {
            $complains = Complain::where('user_id', Auth::user()->id)->with('response', 'response.user',  'user', 'room')->orderBy('created_at', 'desc')->get();
        }
        
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
        $invs = Inventory::all();

        return view('complain.create', ['rooms' => $rooms, 'invs' => $invs] );
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
            'comPic' => new RulesImageUpload
        ]);
        
        $latest_id = Complain::max('id');
        
        if ($validated) {           
            $comPic = $request->file('comPic');

            $complain = new Complain();
            $complain->room_id = $request->room_id;
            $complain->user_id = $request->user_id;
            $complain->date_time = $request->date_time;
            $complain->description = $request->description;
            $complain->barcode = $request->barcode;
            if ($comPic) {
                $path = ($comPic != null) ? Tenant::current()->domain.'/'.'comPic_'.($latest_id + 1).'.'.$comPic->getClientOriginalExtension() : 'no_image.jpg';
                $complain->comPic = '/images/'.$path;
                $comPic->move(public_path().'/images/'.Tenant::current()->domain.'/complains/', 'comPic_'.($latest_id + 1).'.'.$comPic->getClientOriginalExtension());
            }
            $complain->save();
            DB::table('responses')->insert([
                'complain_id' => $complain->id
            ]);

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

    public function ajax(Request $request)
    {
        $data = array();
        $start = $request->get('start');
        $length = $request->get('length');
        $search_term = $request->get('search')['value'];

        if (Auth::user()->roles->pluck('name')[0] == 'staff'||Auth::user()->roles->pluck('name')[0] == 'nurse') {
            $complain = Complain::with('response', 'response.user',  'user', 'room')->whereHas('user', function($query) use ($search_term) {
                $query->where('name', 'like', '%'.$search_term.'%');
            })
            ->orderBy('updated_at', 'desc')
            // ->skip($start)
            // ->take($length)
            ->get();
        } else {
            $complain = Complain::where('user_id', Auth::user()->id)->with('response', 'response.user',  'user', 'room')->whereHas('user', function($query) use ($search_term) {
                $query->where('name', 'like', '%'.$search_term.'%');
            })
            ->orderBy('updated_at', 'desc')
            // ->skip($start)
            // ->take($length)
            ->get();
        }

        foreach ($complain as $com) {
            array_push($data, array(
                'id' => $com->id,
                'user' => $com->user->name,
                'room' => $com->room->room_name,
                'date_time' => $com->date_time,
                'progress_status' => $com->response->progress_status,

            ));
        }

        $array = array(
            'data' => $data,
            'recordsTotal' => Complain::all()->count(),
            'recordsFiltered' => $complain->count(),
            'draw' => $request->get('draw')
        );

        return response()->json($array, 200);
    }

    public function generate($offset)
        {
        $complains = Complain::offset($offset * 100)->take(100)->get();

        ini_set('max_execution_time', 300);
        $pdf = PDF::loadView('complain.pdf', ['complains' => $complains]);

        return $pdf->stream('complain_'.strtotime(date('Y-m-d H:i:s')).'.pdf');
        }

        public function pdf()
        {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff') || Auth::user()->hasRole('nurse')) {
            $complains = Complain::with('response', 'response.user',  'user', 'room')->orderBy('created_at', 'desc')->get();
        } else {
            $complains = Complain::where('user_id', Auth::user()->id)->with('response', 'response.user',  'user', 'room')->orderBy('created_at', 'desc')->get();
        }
        
        return view('complain.pdf', ['complains' => $complains]);
    }
}
