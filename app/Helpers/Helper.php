<?php

use Illuminate\Support\Facades\Route;

setlocale(LC_ALL, 'IND');

function set_active($uri, $output = 'active')
{
    if (is_array($uri)) {
        foreach ($uri as $u) {
            if (Route::is($u)) {
                return $output;
            }
        }
    } else {
        if (Route::is($uri)) {
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
