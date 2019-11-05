<?php

/**
 * Get hijri date from gregorian
 *
 * @author   Faiz Shukri
 * @date     5 Dec 2013
 * @url      https://gist.github.com/faizshukri/7802735
 *
 * Copyright 2013 | Faiz Shukri
 * Released under the MIT license
 */
class HijriDate {

    private $hijri;

    public function __construct($time = false, $adj = 0) {
        if (!$time)
            $time = time();
        $this->hijri = $this->GregorianToHijri($time, $adj);
    }

    public function get_date() {
        return $this->hijri[1] . ' ' . $this->get_month_name($this->hijri[0]) . ' ' . $this->hijri[2] . 'هـ';
    }

    public function get_day() {
        return $this->hijri[1];
    }

    public function get_month() {
        return $this->hijri[0];
    }

    public function get_year() {
        return $this->hijri[2];
    }

    public function get_month_name($i) {
        static $month = array(
            "محرم", "صفر", "ربيع اول", "ربيع آخر",
            "جماد اول", "جماد آخر", "رجب", "شعبان",
            "رمضان", "شوال", "ذو القعدة", "ذو الحجة"
        );
        return $month[$i - 1];
    }

    private function GregorianToHijri($time = null,$adj) {
        if ($time === null)
            $time = time();
        $m = date('m', $time);
        $d = date('d', $time);
        $y = date('Y', $time);

        return $this->JDToHijri(cal_to_jd(CAL_GREGORIAN, $m, $d, $y), $adj);
    }

    private function HijriToGregorian($m, $d, $y) {
        return jd_to_cal(CAL_GREGORIAN, $this->HijriToJD($m, $d, $y));
    }

    # Julian Day Count To Hijri

    private function JDToHijri($jd, $adj) {
        $jd = $jd - 1948440 + 10632 + $adj;
        $n = (int) (($jd - 1) / 10631);
        $jd = $jd - 10631 * $n + 354;
        $j = ((int) ((10985 - $jd) / 5316)) *
                ((int) (50 * $jd / 17719)) +
                ((int) ($jd / 5670)) *
                ((int) (43 * $jd / 15238));
        $jd = $jd - ((int) ((30 - $j) / 15)) *
                ((int) ((17719 * $j) / 50)) -
                ((int) ($j / 16)) *
                ((int) ((15238 * $j) / 43)) + 29;
        $m = (int) (24 * $jd / 709);
        $d = $jd - (int) (709 * $m / 24);
        $y = 30 * $n + $j - 30;

        return array($m, $d, $y);
    }

    # Hijri To Julian Day Count

    private function HijriToJD($m, $d, $y) {
        return (int) ((11 * $y + 3) / 30) +
                354 * $y + 30 * $m -
                (int) (($m - 1) / 2) + $d + 1948440 - 385;
    }

}

//$hijri = new HijriDate(time(),2);
//echo "<p dir='rtl'>" . $hijri->get_date() . "</p>";
