<?php

namespace App\Http\Controllers\Manage\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\Sarpras\Building;
use App\Models\Sarpras\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return view('manage.sarpras.room.index', [
            'rooms' => Room::orderBy('name')->get()
        ]);
    }

    public function create()
    {
        return view('manage.sarpras.room.create', [
            'buildings' => Building::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:rooms,name',
            'building' => 'required',
            'stage' => 'required'
        ]);

        $request['building_id'] = $request->building;

        Room::create($request->all());

        if ($request->stay) {
            $route = 'app.room.create';
        } else {
            $route = 'app.room.index';
        }

        return redirect()->route($route)->with('success', 'Ruangan berhasil ditambahkan');
    }

    public function edit(Room $room)
    {
        return view('manage.sarpras.room.edit', [
            'room' => $room,
            'buildings' => Building::all()
        ]);
    }

    public function update(Room $room, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:rooms,name, ' . $room->id,
            'building' => 'required',
            'stage' => 'required'
        ]);

        $request['building_id'] = $request->building;

        $room->update($request->all());

        return redirect()->route('app.room.index')->with('success', 'Ruangan berhasil diubah');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return back()->with('success', 'Ruangan berhasil dihapus');
    }

    public function _get_stage(Request $request)
    {
        $building = Building::find($request->building_id);
        $options = '<option value="" hidden>Pilih Lantai</option>';

        if ($building) {
            $response_code = '200';
            for ($i = 1; $i <= (int) $building->stage; $i++) {
                $options .= '<option value="' . $i . '">Lantai ' . $i . '</option>';
            }
        } else {
            $response_code = '404';
        }

        return response()->json(['status' => $response_code, 'options' => $options]);
    }
}
