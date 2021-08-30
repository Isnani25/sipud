<?php

function denda($endDays)
{
    $today = date("Y-m-d");
    if ($endDays > $today) {
        $tglKembalikan = strtotime($endDays);
        $sekarang = strtotime($today);

        $jarakWaktu = abs($tglKembalikan - $sekarang);
        $hari = $jarakWaktu / 86400;

        $hari = intval($hari) * 5000;
        return $hari;
    } else {
        return 0;
    }
}

$endDays = "2021-08-19";
echo "Denda: Rp " . number_format(denda($endDays), 2, ',', '.');
