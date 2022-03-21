<?php

namespace App\Http\Controllers\User;

use App\Exports\RoomExport;
use App\Http\Controllers\Controller;
use App\Imports\RoomImport;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::with('inventories')->orderBy('created_at', 'desc')->get();

        return view('room.index', ['rooms' => $rooms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('room.create');
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
            'unit' => 'required|max:255',
            'building' => 'required|max:255',
            'room_name' => 'required|max:255',
            'room_pic' => 'required|max:255',
        ]);

        if ($validated) {
            $room = new Room();
            $room->room_name = $request->room_name;
            $room->unit = $request->unit;
            $room->building = $request->building;
            $room->room_pic = $request->room_pic;
            $room->save();

            if ($request->modal) {
                return back()->with('success', 'New Entry Added');
            } else {
                return redirect()->route('room.index')->with('success', 'New Entry Added');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::with('inventories', 'inventories.latest_record', 'inventories.room')->find($id);
        $legends = DB::select('select d.id, standard_name, count(d.standard_name) c from rooms r inner join 
                inventories i on r.id = i.room_id inner join devices d on i.device_id = d.id 
                where r.id = '.$id.' group by d.standard_name');

        return view('room.show', ['room' => $room, 'inventories' => $room->inventories, 'legends' => $legends]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        return view('room.edit', ['room' => $room]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'unit' => 'required|max:255',
            'building' => 'required|max:255',
            'room_name' => 'required|max:255',
            'room_pic' => 'required|max:255',
        ]);

        if ($validated) {
            $room->room_name = $request->room_name;
            $room->unit = $request->unit;
            $room->building = $request->building;
            $room->room_pic = $request->room_pic;
            $room->update();

            return redirect()->route('room.show', ['id' => $room->id]);
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('room.index');
    }

    public function import()
    {
        Excel::import(new RoomImport, request()->file('file'));

        return redirect()->route('room.index')->with('success', 'Data Imported');
    }

    public function export(Request $request)
    { 
        return Excel::download(new RoomExport, 'room.xlsx');
    }
}
