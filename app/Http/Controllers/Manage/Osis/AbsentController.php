<?php

namespace App\Http\Controllers\Manage\Osis;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\UserPoint;
use App\Models\PenaltyPoint;
use Illuminate\Http\Request;
use App\Jobs\CountUsedUserPenalty;
use App\Http\Controllers\Controller;

class AbsentController extends Controller
{
    public function index()
    {
        return view('manage.osis.absent.index', [
            'user_points' => UserPoint::whereBetween('date', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])->latest()->get()
        ]);
    }

    public function create()
    {
        $this->authorize('read absent');

        return view('manage.osis.absent.create', [
            'penalty_point' => PenaltyPoint::where('code', 'C.1')->first(),
            'users' => User::role('student')->whereHas('schoolyear', function ($query) {
                $query->where('graduated', '0');
            })->get()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create absent');

        $request->validate([
            'users' => 'required|array',
            'date' => 'required|date'
        ]);

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
                $insertPoints[$i]['created_at'] = date('Y-m-d H:i:s', strtotime($request->date));
                $insertPoints[$i]['updated_at'] = date('Y-m-d H:i:s', strtotime($request->date));

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

                    $this->sendWa($model_user, $request->date, '6285156465410');
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

            return redirect()->route('app.absent.create')->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function sendWa($user, $date, $receiver)
    {
        // Notifikasi Whatsapp
        $url = 'https://wagate.biz.id/send-message';
        $sender = '62881026026420';
        $receiver = $receiver;
        $message = "Laporan keterlambatan siswa\n\n";
        $message .= "Kami informasikan bahwa siswa " . $user->name . " terlambat masuk sekolah pada pukul *" . date('H:i', strtotime($date)) . "*\n\n";
        $message .= "cc: Guru Piket SMK BM3";

        $responseWa = wagate($url, $sender, $receiver, $message);
        if ($responseWa->getStatusCode() != 200) {
            $responseWa;
        }
        // End Notifikasi WhatsApp
    }
}
