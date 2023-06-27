<?php

namespace App\Http\Controllers\Manage\Sarpras;

use App\Models\Sarpras\Building;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $this->authorize('create building');

        $buildings = Building::all();
        return view('manage.sarpras.building.index', compact('buildings'));
    }
    
    public function create()
    {
        $this->authorize('create building');

        return view('manage.sarpras.building.create');
    }
    
    public function store(Request $request)
    {
        $this->authorize('create building');

        $rules = [
            'name' => 'required|unique:buildings,name',
            'stage' => 'required',
        ];
        $request->validate($rules);

        Building::create($request->all());
        
        return redirect()->route('app.building.index')->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function edit(Building $building)
    {
        $this->authorize('update building');

        return view('manage.sarpras.building.edit', compact('building'));
    }

    public function update(Building $building, Request $request)
    {
        $this->authorize('update building');

        $request->validate([
            'name' => 'required|unique:buildings,name,' . $building->id,
            'stage' => 'required',
        ]);

        $building->update($request->all());
        
        return redirect()->route('app.building.index')->with('success', 'Gedung berhasil diubah.');
    }

    public function destroy(Building $building)
    {
        $this->authorize('delete building');

        $building->delete();

        return redirect()->route('app.building.index')->with('success', 'Gedung berhasil dihapus.');
    }

}
