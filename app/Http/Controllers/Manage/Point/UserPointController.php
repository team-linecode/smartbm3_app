<?php

namespace App\Http\Controllers\Manage\Point;

use App\Models\User;
use App\Models\PenaltyPoint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\CountUsedUserPenalty;
use App\Models\PenaltyCategory;
use App\Models\UserPoint;
use Carbon\Carbon;

use function GuzzleHttp\Promise\all;

class UserPointController extends Controller
{
    public function index()
    {
        return view('manage.point.user_point.index', [
            'user_points' => UserPoint::latest()->get()
        ]);
    }

    public function create()
    {
        return view('manage.point.user_point.create', [
            'penalty_categories' => PenaltyCategory::orderBy('code')->get(),
            'penalty_points' => PenaltyPoint::orderBy('code')->get(),
            'users' => User::role('student')->get()
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'type' => 'required',
            'users' => 'required|array',
            'date' => 'required|date'
        ];

        // jika tipenya penambahan poin maka pelanggaran harus diisi
        // jika tipenya pengurangan poin keterangan dan jumlah point harus diisi
        if ($request->type == 'plus') {
            $rules['penalty_point'] = 'required';
        } else if ($request->type == 'minus') {
            $rules['description'] = 'required|max:100';
            $rules['point'] = 'required|numeric|min:0|max:100';
        }

        $request->validate($rules);

        // merubah deskripsi mencari huruuf kapital setiap kata
        $request['description'] = ucwords($request->description);

        // dibuat untuk menampung data yang akan dimasukkan
        $insertPoints = [];

        // untuk menampung pesan siswa yang poinnya lebih dari 100 dan poin kurang dari 0
        $messages = "";
        // error poin akan bernilai true jika ada siswa yang poinnya lebihd dari 100 dan poin kurang dari 0
        $error_point = false;

        foreach ($request->users as $i => $user) {
            // mengambil data user berdasarkan id
            $model_user = User::find($user);
            // memisahkan tanggal dengan waktu
            $date = explode('T', $request->date)[0];
            // mengecek user poin berdasarkan user_id, penalty_id, dan tanggal hari ini
            $check_user_point_plus = UserPoint::where('user_id', $user)->where('type', 'plus')->where('penalty_id', $request->penalty_point)->whereBetween('date', [$date . ' 00:00:00', $date . ' 23:59:59'])->first();
            // mengecek user poin berdasarkan user_id, keterangan, dan tanggal hari ini
            $check_user_point_minus = UserPoint::where('user_id', $user)->where('type', 'minus')->where('description', $request->description)->whereBetween('date', [$date . ' 00:00:00', $date . ' 23:59:59'])->first();

            // jika ada data pada query diatas maka data jangan dimasukkan
            // jika tidak ada data pada query diatas maka lanjutkan untuk memasukkan data
            if ($check_user_point_plus || $check_user_point_minus) {
                continue;
            } else {
                // memasukkan data yang akan dimasukkan ke variabel insertPoint
                $insertPoints[$i]['user_id'] = $user;
                $insertPoints[$i]['type'] = $request->type;
                $insertPoints[$i]['date'] = $request->date;
                $insertPoints[$i]['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
                $insertPoints[$i]['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');

                // jika tipenya penambahan poin maka isi variabel penalty_id dengan pelanggaran yang dipilih
                // mengosongkan keterangan dan juga poin
                // point diisi sesuai dengan pelanggaran yang dipilih

                // jika tipenya adalah pengurangan poin maka isi variabel description dengan keterangan yang kita input
                // variabel poin diisi diisi dengan poin yang kita input
                if ($request->type == 'plus') {
                    $insertPoints[$i]['penalty_id'] = $request->penalty_point;

                    $insertPoints[$i]['description'] = null;
                    $insertPoints[$i]['point'] = null;

                    $point = PenaltyPoint::find($request->penalty_point)->point;
                } else if ($request->type == 'minus') {
                    $insertPoints[$i]['description'] = $request->description;
                    $insertPoints[$i]['point'] = $request->point;

                    $insertPoints[$i]['penalty_id'] = null;

                    $point = $request->point;
                }

                // mengecek apakah total poin pada siswa tersebut melebihi 100 atau kurang dari 0
                $total_point = ($request->type == 'plus' ? $model_user->total_points() + $point : $model_user->total_points() - $point);

                if ($total_point > 100) {
                    $error_point = true;
                    $messages .= $model_user->name . " -> Poin sudah melebihi dari 100<br>";
                } else if ($total_point < 0) {
                    $error_point = true;
                    $messages .= $model_user->name . " -> Poin tidak boleh kurang dari 0<br>";
                }
            }
        }

        // jika ada siswa yang poinnya melebihi 100 atau kurang dari 0, tampilkan error
        // jika tidak maka masukkan data ke database
        if ($error_point) {
            return back()->with('alert-error', $messages);
        } else {
            dispatch(new CountUsedUserPenalty([
                "penalty_point_id" => $request->penalty_point,
                "type" => "plus",
                "times" => count($request->users)
            ]));

            UserPoint::insert($insertPoints);

            if ($request->stay) {
                $route = 'app.user_point.create';
            } else {
                $route = 'app.user_point.index';
            }

            return redirect()->route($route)->with('success', 'Poin berhasil ditambahkan');
        }
    }

    public function edit(UserPoint $user_point)
    {
        return view('manage.point.user_point.edit', [
            'user_point' => $user_point,
            'penalty_points' => PenaltyPoint::all(),
            'users' => User::role('student')->get()
        ]);
    }

    public function update(UserPoint $user_point, Request $request)
    {
        $request['type'] = $user_point->type;

        $rules = [
            'date' => 'required|date'
        ];

        // jika tipenya penambahan poin maka pelanggaran harus diisi
        // jika tipenya pengurangan poin keterangan dan jumlah point harus diisi
        if ($request->type == 'plus') {
            $rules['penalty_point'] = 'required';
        } else if ($request->type == 'minus') {
            $rules['description'] = 'required|max:100';
            $rules['point'] = 'required|numeric|min:1|max:100';
        }

        $request->validate($rules);

        // memisahkan tanggal dengan waktu
        $date = explode('T', $request->date)[0];
        // mengecek user poin berdasarkan user_id, penalty_id, dan tanggal hari ini
        $check_user_point_plus = UserPoint::where('user_id', $user_point->user_id)->where('id', '!=', $user_point->id)->where('type', 'plus')->where('penalty_id', $request->penalty_point)->whereBetween('date', [$date . ' 00:00:00', $date . ' 23:59:59'])->first();
        // mengecek user poin berdasarkan user_id, keterangan, dan tanggal hari ini
        $check_user_point_minus = UserPoint::where('user_id', $user_point->user_id)->where('id', '!=', $user_point->id)->where('type', 'minus')->where('description', $request->description)->whereBetween('date', [$date . ' 00:00:00', $date . ' 23:59:59'])->first();

        // jika ada data pada query diatas maka data jangan dimasukkan
        // jika tidak ada data pada query diatas maka lanjutkan untuk memasukkan data
        if ($check_user_point_plus || $check_user_point_minus) {
            return back()->with('alert-error', 'data dengan nama tersebut sudah ada hari ini');
        }

        // mengecek apakah total poin pada siswa tersebut melebihi 100 atau kurang dari 0
        $model_user = $user_point->user;
        $point = $request->type == 'plus' ? PenaltyPoint::find($request->penalty_point)->point : $request->point;
        $total_point = ($request->type == 'plus' ? ($model_user->total_points() + $user_point->point) + $point : ($model_user->total_points() + $user_point->point) - $point);

        // dd($total_point);
        if ($total_point > 100) {
            return back()->with('alert-error', $user_point->user->name . " -> Poin sudah melebihi dari 100<br>");
        } else if ($total_point < 0) {
            return back()->with('alert-error', $user_point->user->name . " -> Poin tidak boleh kurang dari 0<br>");
        }

        // jika penalty point sebelumnya tidak sama dengan yang akan diubah
        // maka kurangi used point pada penalty point sebelumnya dan tambahkan used point ke penalty point yang baru
        if ($user_point->penalty_id != $request->penalty_point) {
            dispatch(new CountUsedUserPenalty([
                "penalty_point_id" => $user_point->penalty_id,
                "type" => "minus",
                "times" => 1
            ]));
            dispatch(new CountUsedUserPenalty([
                "penalty_point_id" => $request->penalty_point,
                "type" => "plus",
                "times" => 1
            ]));
        }

        // jika tipenya penambahan poin maka isi variabel penalty_id dengan pelanggaran yang dipilih
        // mengosongkan keterangan dan juga poin

        // jika tipenya adalah pengurangan poin maka isi variabel description dengan keterangan yang kita input
        // variabel poin diisi diisi dengan poin yang kita input
        // mengosongkan penalty_id
        if ($request->type == 'plus') {
            $user_point->penalty_id = $request->penalty_point;

            $user_point->description = null;
            $request['description'] = null;
            $user_point->point = null;
            $request['point'] = null;
        } else if ($request->type == 'minus') {
            $user_point->description = $request->description;
            $user_point->point = $request->point;

            $user_point->penalty_id = null;
        }

        // ubah type dengan yang dipilih
        // dan melakukan update
        $user_point->update($request->all());

        return redirect()->route('app.user_point.index')->with('success', 'Poin berhasil diubah');
    }

    public function destroy(UserPoint $user_point)
    {
        if ($user_point->type == 'plus') {
            dispatch(new CountUsedUserPenalty([
                "penalty_point_id" => $user_point->penalty_id,
                "type" => "minus",
                "times" => 1
            ]));
        }

        $user_point->delete();
        return back()->with('success', 'Poin berhasil dihapus');
    }
}
