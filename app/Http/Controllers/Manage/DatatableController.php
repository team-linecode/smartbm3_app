<?php

namespace App\Http\Controllers\Manage;

use App\Models\User;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function student_json()
    {
        $this->authorize('developer access');

        return DataTables::of(User::whereHas('role', function ($q) {
            $q->where('name', 'student');
        })->with('classroom')->with('expertise')->select('users.*')->limit(1))
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return $row->name . '<br />
                    <small class="text-muted">
                        Nisn: ' . (!is_null($row->nisn) ? $row->nisn : '<span class="text-danger">tidak ada</span>') .
                    '</small>';
            })
            ->editColumn('password', function ($row) {
                return '<div class="display-password d-flex">
                            <button class="btn py-0 px-2 btn-display-password">
                                <i class="las la-eye-slash text-success"></i>
                            </button>
                            <span class="bg-light rounded px-2 d-none">' . $row->no_encrypt . '</span>
                        </div>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">
                            <div class="edit">
                                <a href="' . route('app.student.edit', $row->id) . '" class="btn btn-sm btn-success">Edit</a>
                            </div>
                            <div class="remove">
                                <form action="' . route('app.student.destroy', $row->id) . '" method="post">
                                    ' . csrf_field() . '
                                    ' . method_field("DELETE") . '
                                    <button type="button" class="btn btn-sm btn-danger c-delete">Hapus</button>
                                </form>
                            </div>
                        </div>';

                return $btn;
            })
            ->rawColumns(['name', 'password', 'action'])
            ->toJson();
    }

    public function student_bill_json()
    {
        $this->authorize('finance access');

        return DataTables::of(User::whereHas('role', function ($q) {
            $q->where('name', 'student');
        })->with('classroom')->with('expertise')->select('users.*')->limit(1))
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return $row->name . '<br />
                    <small class="text-muted">
                        Nisn: ' . (!is_null($row->nisn) ? $row->nisn : '<span class="text-danger">tidak ada</span>') .
                    '</small>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">
                            <div class="edit">
                                <a href="' . route("app.finance.bill.show", $row->id) . '" class="btn btn-sm btn-primary"><i class="ri-file-list-3-line align-middle"></i> Cek Tagihan</a>
                            </div>
                        </div>';

                return $btn;
            })
            ->rawColumns(['name', 'password', 'action'])
            ->toJson();
    }

    public function teacher_json()
    {
        $this->authorize('developer access');

        return DataTables::of(User::whereHas('role', function ($q) {
            $q->where('name', 'teacher');
        })->limit(1))
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return $row->name . '<br />
                    <small class="text-muted">
                        Nip: ' . (!is_null($row->nip) ? $row->nip : '<span class="text-danger">tidak ada</span>') .
                    '</small>';
            })
            ->editColumn('last_education_id', function ($row) {
                return $row->last_education->alias ?? '-';
            })
            ->editColumn('entry_date', function ($row) {
                return $row->entry_date ? date('M Y', strtotime($row->entry_date)) : '-';
            })
            ->editColumn('password', function ($row) {
                return '<div class="display-password d-flex">
                            <button class="btn py-0 px-2 btn-display-password">
                                <i class="las la-eye-slash text-success"></i>
                            </button>
                            <span class="bg-light rounded px-2 d-none">' . $row->no_encrypt . '</span>
                        </div>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">
                            <div class="detail">
                                <a href="" class="btn btn-sm btn-primary">Detail</a>
                            </div>
                            <div class="edit">
                                <a href="' . route('app.teacher.edit', $row->id) . '" class="btn btn-sm btn-success">Edit</a>
                            </div>
                            <div class="remove">
                                <form action="' . route('app.teacher.destroy', $row->id) . '" method="post">
                                    ' . csrf_field() . '
                                    ' . method_field("DELETE") . '
                                    <button type="button" class="btn btn-sm btn-danger c-delete">Hapus</button>
                                </form>
                            </div>
                        </div>';

                return $btn;
            })
            ->rawColumns(['name', 'password', 'action'])
            ->toJson();
    }

    public function staff_json()
    {
        $this->authorize('developer access');

        return DataTables::of(User::whereHas('role', function ($q) {
            $q->whereIn('name', ['staff', 'finance']);
        })->limit(1))
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return $row->name . '<br />
                    <small class="text-muted">
                        Nip: ' . (!is_null($row->nip) ? $row->nip : '<span class="text-danger">tidak ada</span>') .
                    '</small>';
            })
            ->editColumn('last_education', function ($row) {
                return $row->last_education->alias ?? '-';
            })
            ->editColumn('entry_date', function ($row) {
                return $row->entry_date ? date('M Y', strtotime($row->entry_date)) : '-';
            })
            ->editColumn('password', function ($row) {
                return '<div class="display-password d-flex">
                            <button class="btn py-0 px-2 btn-display-password">
                                <i class="las la-eye-slash text-success"></i>
                            </button>
                            <span class="bg-light rounded px-2 d-none">' . $row->no_encrypt . '</span>
                        </div>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex gap-2">
                            <div class="edit">
                                <a href="' . route('app.staff.edit', $row->id) . '" class="btn btn-sm btn-success">Edit</a>
                            </div>
                            <div class="remove">
                                <form action="' . route('app.staff.destroy', $row->id) . '" method="post">
                                    ' . csrf_field() . '
                                    ' . method_field("DELETE") . '
                                    <button type="button" class="btn btn-sm btn-danger c-delete">Hapus</button>
                                </form>
                            </div>
                        </div>';

                return $btn;
            })
            ->rawColumns(['name', 'password', 'action'])
            ->toJson();
    }
}
