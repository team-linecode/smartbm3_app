<?php

namespace App\Http\Controllers\Manage\Picket;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Classroom;
use App\Models\Expertise;
use Illuminate\Http\Request;
use App\Models\StudentAttend;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;

class PicketAbsentController extends Controller
{
    private $secret_key;
    private $wagate_apikey;

    public function __construct()
    {
        $this->secret_key = env('FLIP_SECRET_KEY');
        $this->wagate_apikey = env('WAGATE_APIKEY');
    }

    public function index()
    {
        if (request()->get('classroom') && request()->get('expertise')) {
            $users = User::role('student')->whereHas('schoolyear', function ($query) {
                $query->where('graduated', '0');
            })->where('classroom_id', request()->get('classroom'))
                ->where('expertise_id', request()->get('expertise'))
                ->orderBy('classroom_id')
                ->orderBy('expertise_id')
                ->get();
        } else {
            $users = [];
        }

        return view('manage.picket.absent.create', [
            'classrooms' => Classroom::all(),
            'expertises' => Expertise::orderBy('name')->get(),
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $attend = StudentAttend::where('user_id', $request->user_id)->whereDate('created_at', date('Y-m-d'))->first();

        if (!$attend) {
            $att = StudentAttend::create($request->all());

            $type = 'create';

            $this->sendWa($att, '6285156465410');
        } else {
            if ($attend->status != $request->status) {
                $attend->status = $request->status;
                $attend->update();
                $type = 'change';

                $this->sendWa($attend, '6285156465410');
            } else {
                $attend->delete();
                $type = 'delete';
            }
        }

        return response()->json([
            'code' => 200,
            'type' => $type,
            'user_id' => $request->user_id,
            'status' => $request->status
        ]);
    }

    public function sendWa($attend, $receiver)
    {
        // Notifikasi Whatsapp
        $url = 'https://wagate.biz.id/app/api/send-message';
        $apiKey = $this->wagate_apikey;
        $sender = '62881026026420';
        $receiver = $receiver;
        $message = "Laporan kehadiran siswa\n\n";
        $message .= "Kami mendapatkan informasi bahwa siswa " . $attend->user->name . " tidak hadir sekolah dengan keterangan *" . $attend->status() . "*\n\n";
        $message .= "Jika informasi ini tidak sesuai, harap menghubungi Wali Kelas agar dapat dilakukan tindak lanjut.\n\n\n";
        $message .= "cc: Guru Piket SMK BM3";

        $client = new Client();
        $responseWa = $client->request('GET', $url, [
            'query' => [
                'apikey' => $apiKey,
                'sender' => $sender,
                'receiver' => $receiver,
                'message' => $message,
            ],
        ]);
        
        if ($responseWa->getStatusCode() != 200) {
            $responseWa;
        }
        // End Notifikasi WhatsApp
    }
}
