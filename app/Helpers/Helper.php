<?php

setlocale(LC_ALL, 'IND');

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
