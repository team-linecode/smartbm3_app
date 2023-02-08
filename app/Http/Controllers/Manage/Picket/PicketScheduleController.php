<?php

namespace App\Http\Controllers\Manage\Picket;

use App\Models\User;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\PicketSchedule;

class PicketScheduleController extends Controller
{
    public function index()
    {
        $this->authorize('read picket schedule');

        return view('manage.picket.schedule.index', [
            'picket_schedules' => PicketSchedule::orderBy('day_id')->get()
        ]);
    }

    public function create()
    {
        $this->authorize('create picket schedule');

        return view('manage.picket.schedule.create', [
            'users' => User::role(['teacher', 'staff'])->orderByDesc('name')->get(),
            'days' => Day::orderBy('id')->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create picket schedule');

        $request->validate([
            'day' => 'required|unique:picket_schedules,day_id',
            'users' => 'required|array|max:2'
        ]);

        $request['day_id'] = $request->day;

        $picket_schedule = PicketSchedule::create($request->all());
        $picket_schedule->users()->attach($request->users);

        return redirect(route('app.picket_schedule.index'))->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(PicketSchedule $picket_schedule)
    {
        $this->authorize('update picket schedule');

        return view('manage.picket.schedule.edit', [
            'picket_schedule' => $picket_schedule,
            'users' => User::role(['teacher', 'staff'])->orderByDesc('name')->get(),
            'days' => Day::orderBy('id')->get()
        ]);
    }

    public function update(PicketSchedule $picket_schedule, Request $request)
    {
        $this->authorize('update picket schedule');

        $request->validate([
            'day' => 'required|unique:picket_schedules,day_id,' . $picket_schedule->id,
            'users' => 'required|array|max:2'
        ]);

        $request['day_id'] = $request->day;

        $picket_schedule->update($request->all());
        $picket_schedule->users()->sync($request->users);

        return redirect(route('app.picket_schedule.index'))->with('success', 'Jadwal berhasil diubah');
    }

    public function destroy(PicketSchedule $picket_schedule)
    {
        $this->authorize('delete picket schedule');

        $picket_schedule->users()->detach();
        $picket_schedule->delete();

        return redirect(route('app.picket_schedule.index'))->with('success', 'Jadwal berhasil dihapus');
    }
}
