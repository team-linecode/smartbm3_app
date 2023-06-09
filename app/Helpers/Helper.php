<?php

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Schoolyear;
use App\Models\PenaltyPoint;
use App\Models\LastEducation;
use App\Models\PenaltyCategory;

setlocale(LC_ALL, 'IND');

function set_active($uri, $output = 'active')
{
    if (is_array($uri)) {
        foreach ($uri as $u) {
            if (request()->routeIs($u)) {
                return $output;
            }
        }
    } else {
        if (request()->routeIs($uri)) {
            return $output;
        }
    }
}

function cb_old($value, $old_value, $edit = false, $edited_value = null)
{
    if (!is_null($old_value)) {
        return (in_array($value, $old_value) ? 'checked' : '');
    } else {
        if ($edit) {
            return (in_array($value, $edited_value) ? 'checked' : '');
        }
    }
}

function select_old($value, $old_value = null, $edit = false, $edited_value = null)
{
    if (!$edit) {
        return ($value == $old_value ? 'selected' : '');
    } else {
        return ($value == $edited_value ? 'selected' : '');
    }
}

function select_old_multiple($value, $old_value = null, $edit = false, $edited_value = null)
{
    if (!is_null($old_value)) {
        return (in_array($value, $old_value) ? 'selected' : '');
    } else {
        if ($edit) {
            return (in_array($value, $edited_value) ? 'selected' : '');
        }
    }
}

function cleanCurrency($value)
{
    return str_replace(',', '', $value);
}

function dateRange($begin, $end)
{
    $begin = new DateTime($begin . '-07-01');
    $end = new DateTime($end . '-07-01');
    $interval = new DateInterval('P1M');
    $period = new DatePeriod($begin, $interval, $end);

    $months = [];
    foreach ($period as $dt) {
        $months[] = $dt->format('Y-m-d');
    }

    return $months;
}

function whatsappTransaction($data)
{
    $details = "";
    foreach ($data['details'] as $i => $trx_detail) {
        $details .= ($i + 1) . ".%20" . $trx_detail->cost_detail->cost->name . "%20%5Bdetail%3A%20" . $trx_detail->cost_detail_by_category($trx_detail->cost_detail->id, $trx_detail->cost_detail->cost->id) . "%5D%20%5Bbulan%3A%20" . date('M') . " " . date('Y') ?? '-' . "%5D%0A%20%20%20Rp.%20" . '-' . "%0A";
    }
    return "https://wa.me/6285156465410?text=*%5BBUKTI%20PEMBAYARAN%5D*%0A" . $data['name'] . "%20Telah%20melakukan%20pembayaran%20sekolah%2C%20Dengan%20rincian%20sebagai%20berikut.%0A%0A*%5BDATA%5D*%0ANO%20INVOICE%20%3A%20" . $data['invoice_id'] . "%0ANAMA%20%3A%20" . $data['name'] . "%0AKELAS%20%3A%20" . $data['classroom'] . "%0AJURUSAN%20%3A%20" . $data['expertise'] . "%0ATANGGAL%20%3A%20" . $data['date'] . "%0AMETODE%20PEMBAYARAN%20%3A%20" . $data['payment_method'] . "%0A%0A*%5BDETAIL%20TRANSAKSI%5D*%0A" . $details . "%0A%0A_informasi%20ini%20bersifat%20resmi%2C%20dikirim%20oleh%20bendahara%20SMK%20Bina%20Mandiri%20Multimedia_%0A%0A_kami%20hanya%20menghubungi%20dengan%20nomor%20ini%2C%20jika%20ada%20nomor%20lain%20yang%20mengatasnamakan%20SMK%20BM3%20harap%20diwaspadai_";
}

function teachingHonor($last_education_id)
{
    $last_education = LastEducation::find($last_education_id);

    if (!$last_education) {
        return 0;
    } else {
        switch ($last_education->slug) {
            case 'sma':
                return 25000;
                break;
            case 's1':
                return 35000;
                break;
            case 's2':
                return 40000;
                break;
            default:
                return 0;
                break;
        }
    }
}

function yearExperience($entryDate)
{
    $entry_year = date('Y', strtotime($entryDate));
    $entry_month = date('m', strtotime($entryDate));

    $current_year = date('Y');
    $current_month = date('m');

    $diff = (($current_year - $entry_year) * 12) + ($current_month - $entry_month);

    return round($diff / 12);
}

function yearExperienceHonor($userId)
{
    $user = User::find($userId);

    if (!$user) {
        return 0;
    } else {
        if ($user->status == 'GTY' || $user->status == 'KTY') {
            $yearExperience = yearExperience($user->entry_date);

            switch ($yearExperience) {
                case $yearExperience >= 0 && $yearExperience <= 5:
                    return 100000;
                    break;
                case $yearExperience >= 6 && $yearExperience <= 10:
                    return 150000;
                    break;
                case $yearExperience >= 11 && $yearExperience <= 15:
                    return 200000;
                    break;
                case $yearExperience >= 16 && $yearExperience <= 20:
                    return 250000;
                    break;
                case $yearExperience > 20:
                    return 500000;
                    break;
                default:
                    return 0;
                    break;
            }
        } else {
            return 0;
        }
    }
}

function familyAllowance($userId)
{
    $user = User::find($userId);

    if (!$user) {
        return 0;
    } else {
        $gender_marital_status = ($user->gender == 'Pria') && ($user->marital_status == 1);

        switch ($user) {
            case $gender_marital_status  && ($user->child == 0):
                return 100000;
                break;
            case $gender_marital_status && ($user->child == 1):
                return 150000;
                break;
            case $gender_marital_status && ($user->child >= 2):
                return 200000;
                break;
            default:
                return 0;
                break;
        }
    }
}

function formulas()
{
    return [
        '[POTMJW]', // pot. mengajar jam wajib
        '[POTBPJS]', // pot. kesehatan bpjs
        '[PTABJHT]', // pot. tabungan jht
        '[POTKOPR]', // pot. koperasi
        '[TJJBTN]', // tj. jabatan
        '[TJMSKJ]', // tj. masa kerja
        '[TJKLRG]', // tj. keluarga
        '[TJBPJS]', // tj. kesehatan bpjs
        '[TJTJHT]', // tj. tabungan jht
        '[TJKHDR]', // insentive kehadiran
        '[TJPIKT]', // tj. piket
        '[TJWALS]', // tj. wali kelas
        '[TJTRNS]', // tj. transport
        '[HNRMJR]', // honor mengajar
        '[HNRMES]', // honor eksekutif subjek
        '[HNESKL]', // honor eskul
    ];
}

function getFormula($formula, $userId)
{
    $user = User::find($userId);

    if (!$user) {
        return 0;
    } else {
        switch ($formula) {
            case '[TJJBTN]': // tj. jabatan
                return $user->positions->sum('salary');
                break;
            case '[TJMSKJ]': // tj. masa kerja
                return yearExperienceHonor($user->id);
                break;
            case '[TJKLRG]': // tj. keluarga
                return familyAllowance($user->id);
                break;
            case '[TJWALS]': // tj. wali kelas
                return $user->positions()->where('slug', 'wali-kelas')->exists() ? 200000 : 0;
                break;
            case '[TJTRNS]': // tj. transport
                return 50000 * 26;
                break;
            case '[HNRMJR]': // honor mengajar
                return $user->lessons()->sum('hours') * teachingHonor($user->last_education_id);
                break;
            default:
                return 0;
                break;
        }
    }
}

function formulaExists($formula)
{
    return in_array($formula, formulas()) ? true : false;
}

function penaltyCode()
{
    $letters = [];
    foreach (range('A', 'Z') as  $letter) {
        $letters[] = $letter;
    }
    foreach (range('A', 'Z') as  $letter) {
        foreach (range('A', 'Z') as $letter2) {
            $letters[] = $letter . $letter2;
        }
    }

    return $letters;
}

function getPenaltyCategoryCode()
{
    $penalty_category = PenaltyCategory::all()->count();
    return penaltyCode()[$penalty_category];
}

function getPenaltyPointCode($penalty_category_code)
{
    if ($penalty_category_code == null) {
        return false;
    } else {
        $penalty_point = PenaltyPoint::whereHas('category', function ($penalty_category) use ($penalty_category_code) {
            $penalty_category->where('code', $penalty_category_code);
        })->count();

        return $penalty_category_code . "." . ($penalty_point + 1);
    }
}

function dayID(int $day)
{
    switch ($day) {
        case '1':
            return "Senin";
            break;
        case '2':
            return "Selasa";
            break;
        case '3':
            return "Rabu";
            break;
        case '4':
            return "Kamis";
            break;
        case '5':
            return "Jumat";
            break;
        case '6':
            return "Sabtu";
            break;
        case '7':
            return "Minggu";
            break;
        default:
            return "Invalid Day";
            break;
    }
}

function monthID(int $month)
{
    switch ($month) {
        case '1':
            return "Januari";
            break;
        case '2':
            return "Februari";
            break;
        case '3':
            return "Maret";
            break;
        case '4':
            return "April";
            break;
        case '5':
            return "Mei";
            break;
        case '6':
            return "Juni";
            break;
        case '7':
            return "Juli";
            break;
        case '8':
            return "Agustus";
            break;
        case '9':
            return "September";
            break;
        case '10':
            return "Oktober";
            break;
        case '11':
            return "November";
            break;
        case '12':
            return "Desember";
            break;
        default:
            return "Invalid Month";
            break;
    }
}

function status_attend($s)
{
    if ($s == 's') {
        $r = 'Sakit';
    } elseif ($s == 'i') {
        $r = 'Izin';
    } elseif ($s == 'a') {
        $r = 'Alfa';
    }
    return $r;
}

function getSPPdate($classroom_id, $schoolyear_id, $month)
{
    if ($month < 10) {
        $month = '0' . $month;
    }

    $schoolyear = Schoolyear::findOrFail($schoolyear_id);
    $explode_schoolyear = explode('-', $schoolyear->slug);

    $years = range($explode_schoolyear[0], $explode_schoolyear[1]);
    $july_to_december = ['7', '8', '9', '10', '11', '12'];
    $january_to_june = ['1', '2', '3', '4', '5', '6'];

    if ($classroom_id == '1' && in_array($month, $july_to_december)) {
        return $years[0] . '-' . $month;
    } else if ($classroom_id == '1' && in_array($month, $january_to_june)) {
        return $years[1] . '-' . $month;
    } else if ($classroom_id == '2' && in_array($month, $july_to_december)) {
        return $years[1] . '-' . $month;
    } else if ($classroom_id == '2' && in_array($month, $january_to_june)) {
        return $years[2] . '-' . $month;
    } else if ($classroom_id == '3' && in_array($month, $july_to_december)) {
        return $years[2] . '-' . $month;
    } else if ($classroom_id == '3' && in_array($month, $january_to_june)) {
        return $years[3] . '-' . $month;
    } else {
        return "1997-01";
    }
}

function wagate($url, $sender, $receiver, $message)
{
    $client = new Client();

    $response = $client->request('GET', $url, [
        'query' => [
            'api_key' => env('WAGATE_APIKEY'),
            'sender' => $sender,
            'number' => $receiver,
            'message' => $message,
        ],
    ]);

    return $response;
}

function schedule_message($message)
{   
    $client = new Client();
    $telp = ['6281319499900','6281818122257','6285966244278', '6285692686660', '6281283625303', '6281287577202'];
    // $telp = ['6289601271842','6285156465410', '6285156146724'];
    foreach ($telp as $no) {
        $response = $client->request('GET', 'https://wagate.biz.id/send-message', [
            'query' => [
                'api_key' => 'Re9c3tRgrB3hIumZ1rAQD28yCAaEmHOY',
                'sender' => '6281311596411',
                'number' => $no,
                'message' => $message,
            ],
        ]);
    }
}