<?php

namespace App\Http\Controllers\Manage\Sarpras;

use App\Http\Controllers\Controller; 
use App\Models\Sarpras\Facility;
use Illuminate\Http\Request;
use App\Models\Sarpras\Submission;
use App\Models\Sarpras\SubmissionDetail;
use App\Models\Sarpras\Room;
use Pdf;

class SubmissionController extends Controller
{
    public function index()
    {
        $this->authorize('read submission');
        if(auth()->user()->hasRole('FI') or auth()->user()->hasRole('principal') or auth()->user()->hasRole('HOF')){
            $submissions = Submission::all();
        }else{
            $submissions = Submission::where('user_id', auth()->user()->id)->get();
        }

        return view('manage.sarpras.submission.index', [
            'submissions' => $submissions
        ]);
        // return view('manage.sarpras.submission.index');
    }

    public function create()
    {
        $this->authorize('create submission');
        $facilities = Facility::all();
        $rooms = Room::all();

        if (session('total_input_data') < 1) {
            session()->put('total_input_data', 1);
        }

        return view('manage.sarpras.submission.create', [
            'facilities' => $facilities,
            'rooms' => $rooms
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create submission');

        $rules = [
            'facility_id.*' => 'required',
            'room_id.*' => 'required',
            'date_required.*' => 'required',
            'necessity.*' => 'required',
            'qty.*' => 'required',
            'price.*' => 'required',
        ];
        // dd($request->all());
        $check_submission = Submission::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();
        $number = $check_submission->count() + 1;
        $sub_number = 'PGJN' . date('m') . date('Y') . $number;
        $attr['user_id'] = auth()->user()->id;
        $attr['invoice'] = $sub_number;
        $request->validate($rules);

        $submission_create = Submission::create($attr);
        $s_id = $submission_create->id;
        $submission = Submission::find($s_id);
        if($submission_create){
            foreach ($request->facility_id as $i => $facility) {
                $facility_name = Facility::find($facility);
                
                $attr2[$i]['submission_id'] = $s_id;
                $attr2[$i]['facility_id'] = $facility;
                $attr2[$i]['facility_name'] = $facility_name->name;
            }
            foreach ($request->room_id as $i => $room) {
                $attr2[$i]['room_id'] = $room;
            }
            foreach ($request->date_required as $i => $date_required) {
                $attr2[$i]['date_required'] = $date_required;
            }
            foreach ($request->qty as $i => $qty) {
                $attr2[$i]['qty'] = $qty;
            }
            foreach ($request->price as $i => $price) {
                $attr2[$i]['price'] = $price;
            }
            foreach ($request->postage_price as $i => $postage_price) {
                $attr2[$i]['postage_price'] = $postage_price;
            }
            foreach ($request->total_price as $i => $total_price) {
                $attr2[$i]['total_price'] = $attr2[$i]['price'] * $attr2[$i]['qty'] + $attr2[$i]['postage_price'];;
            }
            foreach ($request->necessity as $i => $necessity) {
                $attr2[$i]['necessity'] = $necessity;
            }
            // $attr2['room_id'] = $request->room_id;
            // $attr2['date_required'] = $request->date_required;
            // $attr2['qty'] = $request->qty;
            // $attr2['price'] = $request->price;
            // $attr2['postage_price'] = $request->postage_price;
            // $attr2['total_price'] = $request->price * $request->qty + $request->postage_price;
            // $attr2['necessity'] = $request->necessity;

            // dd($attr2);
            SubmissionDetail::insert($attr2);
        }

        if ($request->stay) {
            $route = 'app.submission.create';
        } else {
            $route = 'app.submission.index';
        }

        return redirect()->route($route)->with('success', 'Pengajuan berhasil ditambahkan.');
    }

    public function edit(Submission $submission)
    {
        $this->authorize('update submission');
        $s_detail = SubmissionDetail::where('submission_id', $submission->id)->first();
        $facilities = Facility::all();
        $rooms = Room::all();
        return view('manage.sarpras.submission.edit', [
            'submission' => $s_detail,
            'facilities' => $facilities,
            'rooms' => $rooms
        ]);
    }

    public function update(Submission $submission, Request $request)
    {
        $this->authorize('update submission');

        $rules = [
            'facility_id' => 'required',
            'room_id' => 'required',
            'date_required' => 'required',
            'necessity' => 'required',
            'qty' => 'required',
            'price' => 'required',
        ];

        $request->validate($rules);

        $find_submission = SubmissionDetail::where('submission_id', $submission->id)->first();

        $find_submission->update($request->all());

        return redirect()->route('app.submission.index')->with('success', 'Pengajuan berhasil diubah.');
    }

    public function destroy(Submission $submission)
    {
        $this->authorize('delete submission');

        $s_detail = SubmissionDetail::where('submission_id', $submission->id)->first();
        $s_detail->delete();
        $submission->delete();

        return redirect()->route('app.submission.index')->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function accept(Submission $submission)
    {
        $this->authorize('accept submission');
        $step = $submission->step;
        if (auth()->user()->hasRole('FI')) {
            if ($step > 1) {
                return back()->with('error', 'Sudah diterima Kepala Sekolah!');
            } else {
                $submission->step = $submission->step + 1;
                $submission->update();
                return redirect()->route('app.submission.index')->with('success', 'Pengajuan berhasil diterima.');
            }
        } elseif (auth()->user()->hasRole('principal')) {
            if ($step > 2) {
                return back()->with('error', 'Sudah diterima Yayasan!');
            } elseif ($step < 2) {
                return back()->with('error', 'Belum diterima Sarpras!');
            } else {
                $submission->step = $submission->step + 1;
                $submission->update();
                return redirect()->route('app.submission.index')->with('success', 'Pengajuan berhasil diterima.');
            }
        } elseif (auth()->user()->hasRole('HOF')) {
            if ($step < 3) {
                return back()->with('error', 'Belum diterima Kepala Sekolah!');
            } elseif ($step < 2) {
                return back()->with('error', 'Belum diterima Sarpras!');
            } else {
                $submission->status = 'diterima';
                $submission->update();
                return redirect()->route('app.submission.index')->with('success', 'Pengajuan berhasil diterima.');
            }
        } else {
            return back()->with('error', 'Anda tidak memiliki akses!');
        }
    }

    public function reject(Submission $submission, Request $request)
    {
        $this->authorize('accept submission');
        $step = $submission->step;
        if (auth()->user()->hasRole('FI') or auth()->user()->hasRole('developer')) {
            if ($step > 1) {
                return back()->with('error', 'Sudah diterima Kepala Sekolah!');
            } else {
                $submission->status = 'ditolak';
                $submission->note = $request->note;
                $submission->update();
                return redirect()->route('app.submission.index')->with('success', 'Pengajuan berhasil ditolak.');
            }
        } elseif (auth()->user()->hasRole('principal')) {
            if ($step > 2) {
                return back()->with('error', 'Sudah diterima Yayasan!');
            } elseif ($step < 2) {
                return back()->with('error', 'Belum diterima Sarpras!');
            } else {
                $submission->status = 'ditolak';
                $submission->note = $request->note;
                $submission->update();
                return redirect()->route('app.submission.index')->with('success', 'Pengajuan berhasil ditolak.');
            }
        } elseif (auth()->user()->hasRole('HOF')) {
            if ($step < 3) {
                return back()->with('error', 'Belum diterima Kepala Sekolah!');
            } elseif ($step < 2) {
                return back()->with('error', 'Belum diterima Sarpras!');
            } else {
                $submission->status = 'ditolak';
                $submission->note = $request->note;
                $submission->update();
                return redirect()->route('app.submission.index')->with('success', 'Pengajuan berhasil ditolak.');
            }
        } else {
            return back()->with('error', 'Anda tidak memiliki akses!');
        }
    }

    public function plus_input()
    {
        $this->authorize('create submission');

        $plus = session('total_input_data') + 1;

        session()->put('total_input_data', $plus);

        return response()->json(['status' => 'success', 'total' => $plus]);
    }

    public function minus_input(Request $request)
    {
        $this->authorize('create submission');

        if (session('total_input_data') == 1) {
            return response()->json(['status' => 'error']);
        } else {
            $minus = session('total_input_data') - 1;
        }

        session()->put('total_input_data', $minus);

        return response()->json(['status' => 'success', 'total' => $minus]);
    }

    public function invoice(Submission $submission)
    {
        
        $total_price = SubmissionDetail::where('submission_id', $submission->id)->get()->sum('total_price');
        // $submission['total_price'] = $total_price;
        // view()->share('submission', $submission);
        // $pdf = PDF::loadView('manage.sarpras.submission.invoice', $submission->toArray())->setPaper('A4', 'landscape');
        // return $pdf->stream('invoice_' . $submission->invoice . '.pdf');

        return view('manage.sarpras.submission.invoice', [
            'submission' => $submission,
            'total_price' => $total_price
        ]);
    }
}
