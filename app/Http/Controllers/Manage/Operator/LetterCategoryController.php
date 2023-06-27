<?php

namespace App\Http\Controllers\Manage\Operator;

use App\Models\Sarpras\Room;
use Illuminate\Http\Request;
use App\Models\Sarpras\Building;
use App\Models\Sarpras\Facility;
use App\Http\Controllers\Controller;
use App\Models\LetterCategory;

class LetterCategoryController extends Controller
{
    public function index()
    {
        return view('manage.operator.letter_category.index', [
            'letter_categories' => LetterCategory::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:letter_categories,name',
        ]);

        LetterCategory::create($request->all());

        return back()->with('success', 'Kategori Surat berhasil ditambahkan');
    }

    public function edit(LetterCategory $letter_category)
    {
        return view('manage.operator.letter_category.edit', [
            'lettercategory' => $letter_category,
        ]);
    }

    public function update(LetterCategory $letter_category, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:letter_categories,name',
        ]);

        $letter_category->update($request->all());

        return redirect()->route('app.letter_category.index')->with('success', 'Kategori Surat berhasil diubah');
    }

    public function destroy(LetterCategory $letter_category)
    {
        $letter_category->delete();

        return back()->with('success', 'Kategori surat berhasil dihapus');
    }

    public function store_facility(Room $room, Request $request)
    {
        $request->validate([
            'facility' => 'required',
            'procurement_year' => 'numeric|min:2000|max:'.date('Y'),
            'good' => 'required|numeric|min:0',
            'bad' => 'required|numeric|min:0',
            'broken_can_repaired' => 'required|numeric|min:0',
            'broken_cant_repaired' => 'required|numeric|min:0',
        ]);

        $request['room_id'] = $room->id;
        $request['facility_id'] = $request->facility;
        $request['total'] = ($request->good + $request->bad + $request->broken_can_repaired + $request->broken_cant_repaired);

        $rf = RoomFacility::where('room_id', $room->id)->where('facility_id', $request->facility)->get()->count();
        if($rf > 0){
            return back()->with('error', 'Sarana telah terdata pada ruangan ini!');
        }else{
            RoomFacility::create($request->all());
        }

        return back()->with('success', 'Sarana berhasil ditambahkan');
    }

    public function edit_facility(Room $room, RoomFacility $facility)
    {
        return view('manage.sarpras.room.edit_facility', [
            'room' => $room,
            'rf' => $facility,
            'facilities' => Facility::all()
        ]);
    }

    public function update_facility(Room $room, RoomFacility $facility, Request $request)
    {
        $request->validate([
            'procurement_year' => 'numeric|min:2000|max:'.date('Y'),
            'good' => 'required|numeric|min:0',
            'bad' => 'required|numeric|min:0',
            'broken_can_repaired' => 'required|numeric|min:0',
            'broken_cant_repaired' => 'required|numeric|min:0',
        ]);
        
        $request['total'] = ($request->good + $request->bad + $request->broken_can_repaired + $request->broken_cant_repaired);
        $facility->update($request->all());

        return redirect()->route('app.room.show', $room->id)->with('success', 'Sarana berhasil diubah');
    }

    public function delete_facility(Room $room, RoomFacility $facility)
    {
        $facility->delete();
        return back()->with('success', 'Sarana berhasil dihapus');
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
