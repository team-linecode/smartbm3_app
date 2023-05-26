<?php

namespace App\Http\Controllers\Manage\LoanManage;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Expertise;
use App\Models\LoanMember;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LoanMemberController extends Controller
{
    public function index()
    {
        return view('manage.loan_manage.member.index', [
            'loan_members' => LoanMember::orderBy('classroom_id')->orderBy('expertise_id')->get(),
        ]);
    }

    public function create()
    {
        return view('manage.loan_manage.member.create', [
            'users' => User::role('student')->whereHas('schoolyear', function ($query) {
                $query->where('graduated', '0');
            })->get(),
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'classroom' => 'required',
            'expertise' => 'required'
        ];

        $request->validate($rules);

        $check_class = LoanMember::where('classroom_id', $request->classroom)
            ->where('expertise_id', $request->expertise)
            ->first();

        if ($check_class) {
            return back()->with('error', 'Kelas sudah ada');
        }

        $request['classroom_id'] = $request->classroom;
        $request['expertise_id'] = $request->expertise;

        $create = LoanMember::create($request->all());
        $create->uid = Str::uuid();
        QrCode::size(400)->generate($create->uid, public_path('storage/qrcode/' . $create->uid . '.svg'));
        $create->qrcode = '/qrcode/' . $create->uid . '.svg';

        $create->save();

        if ($request->stay) {
            $route = 'app.loan_member.create';
        } else {
            $route = 'app.loan_member.index';
        }

        return redirect()->route($route)->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit()
    {
        return view('manage.loan_manage.member.edit');
    }

    public function update()
    {
    }

    public function destroy(LoanMember $loan_member)
    {
        Storage::disk('public')->delete($loan_member->qrcode);
        $loan_member->delete();

        return redirect()->route('app.loan_member.index')->with('success', 'Member berhasil dihapus');
    }
}
