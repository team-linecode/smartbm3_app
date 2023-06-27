<?php

namespace App\Http\Controllers\Manage\Sarpras;

use App\Http\Controllers\Controller;
use App\Models\RoomFacility;
use Illuminate\Http\Request;
use App\Models\Sarpras\Facility;
use App\Models\Sarpras\Room;
use App\Models\Sarpras\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('manage.sarpras.service.index', [
            'rooms' => Room::orderBy('name')->get(),
            'services' => Service::orderBy('date')->get()
        ]);
    }

    public function _get_facility(Request $request)
    {
        $rf = RoomFacility::where('room_id', $request->room_id)->get();
        echo '<option value="" hidden>Pilih Fasilitas</option>';
        foreach($rf as $rf){
            echo "<option value='" . $rf->facility_id . "'>" . $rf->facility->name . "</option>";
        }
    }

    public function store(Request $request)
    {   
        $request->validate([
            'room_id' => 'required',
            'facility_id' => 'required',
            'date' => 'required'
        ]);

        Service::create($request->all());

        return redirect()->route('app.service.index')->with('success', 'Servis berhasil ditambahkan');
    }
    
    public function edit(Service $service)
    {
        return view('manage.sarpras.service.edit', [
            'service' => $service,
            'rooms' => Room::orderBy('name')->get(),
            'room_facilities' => RoomFacility::where('room_id', $service->room_id)->get(),
            'services' => Service::orderBy('date')->get()
        ]);
    }

    public function update(Service $service, Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'facility_id' => 'required',
            'date' => 'required'
        ]);

        $service->update($request->all());

        return redirect()->route('app.service.index')->with('success', 'Data Servis berhasil diubah');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return back()->with('success', 'Data servis berhasil dihapus');
    }
}
