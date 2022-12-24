<?php

use App\Models\LastEducation;
use App\Models\User;

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
    if (!is_null($old_value)) {
        return ($value == $old_value ? 'selected' : '');
    } else {
        if ($edit) {
            return ($value == $edited_value ? 'selected' : '');
        }
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
