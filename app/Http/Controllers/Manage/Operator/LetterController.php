<?php

namespace App\Http\Controllers\Manage\Operator;

use App\Models\Sarpras\Facility;
use App\Models\RoomFacility;
use App\Http\Controllers\Controller;
use App\Models\LetterCategory;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    public function index()
    {
        $this->authorize('read letter');

        return view('manage.operator.letter_category.index', [
            'letter_categories' => LetterCategory::orderBy('name')->get()
        ]);

        return view('manage.operator.letter.index');
    }

    public function create()
    {
        $this->authorize('create facility');

        return view('manage.sarpras.facility.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create facility');

        $rules = [
            'name' => 'required',
            'brand' => 'required',
        ];

        $find_name = Facility::where('name', $request->name)->get();
        if($find_name->count() > 0){
            $find_brand = Facility::where('brand', $request->brand)->get();
            if($find_brand->count() > 0){
                return back()->with('error', 'Sarana sudah ada.');
            }
        }

        $request->validate($rules);

        Facility::create($request->all());

        if ($request->stay) {
            $route = 'app.facility.create';
        } else {
            $route = 'app.facility.index';
        }

        return redirect()->route($route)->with('success', 'Sarana berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        $this->authorize('update facility');

        return view('manage.sarpras.facility.edit', [
            'facility' => $facility
        ]);
    }

    public function update(Facility $facility, Request $request)
    {
        $this->authorize('update facility');

        $request->validate([
            'name' => 'required',
            'brand' => 'required',
        ]);

        $find_name = Facility::where('name', $request->name)->where('id', '!=', $facility->id)->get();
        if($find_name->count() > 0){
            $find_brand = Facility::where('brand', $request->brand)->where('id', '!=', $facility->id)->get();
            if($find_brand->count() > 0){
                return back()->with('error', 'Sarana sudah ada.');
            }
        }

        $facility->update($request->all()); 

        return redirect()->route('app.facility.index')->with('success', 'Sarana berhasil diubah.');
    }

    public function destroy(Facility $facility)
    {
        $this->authorize('delete facility');
        
        $rc = RoomFacility::where('facility_id', $facility->id);
        if($rc->exists()){
            $rc->delete();
        }
        $facility->delete();

        return redirect()->route('app.facility.index')->with('success', 'Sarana berhasil dihapus.');
    }
}
