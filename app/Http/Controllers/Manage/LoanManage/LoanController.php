<?php

namespace App\Http\Controllers\Manage\LoanManage;

use App\Models\Loan;
use App\Models\User;
use App\Models\LoanMember;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Expertise;
use App\Models\LoanApprover;
use App\Models\Position;
use App\Models\Sarpras\Room;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index()
    {
        return view('manage.loan_manage.loan.index', [
            'loans' => Loan::whereHas('approvers', function ($q) {
                $q->where('user_id', auth()->user()->id);
            })
                ->orderByDesc('loan_date')->get(),
            'users' => User::role('student')->whereHas('schoolyear', function ($query) {
                $query->where('graduated', '0');
            })->get(),
            'teachers' => User::role('teacher')->orderBy('name')->get(),
            'approvers' => Position::all(),
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::orderByDesc('name')->get(),
            'rooms' => Room::all()
        ]);
    }

    public function create()
    {
        return view('manage.loan_manage.loan.create', [
            'users' => User::role('student')->whereHas('schoolyear', function ($query) {
                $query->where('graduated', '0');
            })->get(),
            'teachers' => User::role('teacher')->orderBy('name')->get(),
            'approvers' => Position::all(),
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::orderByDesc('name')->get(),
            'rooms' => Room::all()
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'room' => 'required',
            'loan_date' => 'required|date',
            'estimation_return_date' => 'required|date'
        ];

        // jika ada kelas dan jurusan maka penanggung jawab harus diisi
        if ($request->user) {
            $rules['user'] = 'required';
        }

        $request->validate($rules);

        $loan = Loan::create($request->all());
        $loan->uid = Str::uuid();

        // jika ada kelas dan jurusan maka cari member dan masukkan idnya
        if ($request->user) {
            $user = User::findOrFail($request->user);
            $member = LoanMember::where('classroom_id', $user->classroom_id)
                ->where('expertise_id', $user->expertise_id)->first();
            if ($member) {
                $loan->loan_member_id = $member->id;
                $loan->user_id = $request->user;
            } else {
                abort('404');
            }
        }

        // jika ada pengajar maka masukkan teacher_id
        if ($request->teacher) {
            $loan->teacher_id = $request->teacher;
        }

        // input ruangan
        $loan->room_id = $request->room;

        // jika deskripsi dinput maka masukkan ke database
        if ($request->description) {
            $loan->description = $request->description;
        }

        // jika meminjam barang maka masukkan ke table loan_facilities
        if ($request->facilities) {
            $loan->facilities()->attach($request->facilities);
        }

        // jika perlu persetujuan dari divisi lain maka masukkan ke table loan approvers
        $insert_approvers = [];
        $insert_approvers[0]['loan_id'] = $loan->id;
        $insert_approvers[0]['user_id'] = auth()->user()->id;
        $insert_approvers[0]['status']  = 'accept';
        $insert_approvers[0]['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $insert_approvers[0]['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
        if ($request->approvers) {
            foreach ($request->approvers as $i => $app) {
                $insert_approvers[$i + 1]['loan_id'] = $loan->id;
                $insert_approvers[$i + 1]['user_id'] = $app;
                $insert_approvers[$i + 1]['status'] = 'pending';
                $insert_approvers[$i + 1]['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
                $insert_approvers[$i + 1]['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            }
        }
        LoanApprover::insert($insert_approvers);

        $loan->save();

        return redirect()->route('app.loan.index')->with('success', 'Peminjaman berhasil disimpan');
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy(Loan $loan)
    {
        $loan->facilities()->detach();
        $loan->approvers()->delete();
        $loan->delete();

        return back()->with('success', 'Peminjaman berhasil dihapuss');
    }

    public function find_members_by_scan(Request $request)
    {
        $data['member'] = LoanMember::where('uid', $request->uid)->first();

        if ($data['member']) {
            return response()->json(['code' => 200, 'data' => $data]);
        } else {
            return response()->json(['code' => 404]);
        }
    }

    public function find_users_by_class(Request $request)
    {
        $users = User::role('student')
            ->where('classroom_id', $request->classroom_id)
            ->where('expertise_id', $request->expertise_id)
            ->orderBy('name')
            ->get();

        if ($users) {
            $options = '<option value="" hidden>Pilih Nama</option>';
            foreach ($users as $user) {
                $options .= '<option value="' . $user->id . '" ' . select_old($user->id, old('user')) . '>' . $user->name . '</option>';
            }

            return response()->json(['code' => '200', 'options' => $options]);
        } else {
            return response()->json(['code' => '404']);
        }
    }

    public function find_facilities_by_room(Request $request)
    {
        $room = Room::find($request->room_id);
        // dd($room->facilities);

        if ($room) {
            $options = '<option value="" hidden>Pilih Barang</option>';
            foreach ($room->facilities as $rf) {
                $options .= '<option value="' . $rf->facility->id . '" ' . select_old_multiple($rf->facility->id, old('facilities')) . '>' . $rf->facility->name . '</option>';
            }

            return response()->json(['code' => '200', 'options' => $options]);
        } else {
            return response()->json(['code' => '404']);
        }
    }

    public function get_detail(Request $request)
    {
        $loan = Loan::where('uid', $request->uid)
            ->with('member')
            ->with('facilities')
            ->with('approvers')
            ->first();

        if ($loan) {
            return response()->json(['code' => 200, 'data' => $loan]);
        } else {
            return response()->json(['code' => 404]);
        }
    }
}
