<?php

namespace App\Http\Controllers\Manage\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\Sarpras\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return view('manage.sarpras.room.index');
    }

    public function create()
    {
        return view('manage.sarpras.room.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:rooms, name',
            'building' => 'required',
            'stage' => 'required'
        ]);

        $request['name'] = strtolower($request->name);
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
            'room' => $room
        ]);
    }

    public function update(Room $room, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:rooms, name, ' . $room->id,
            'building' => 'required',
            'stage' => 'required'
        ]);

        $request['name'] = strtolower($request->name);
        $request['building_id'] = $request->building;

        $room->update($request->all());

        return redirect()->route('app.room.index')->with('success', 'Ruangan berhasil diubah');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return back()->with('success', 'Ruangan berhasil dihapus');
    }
}
