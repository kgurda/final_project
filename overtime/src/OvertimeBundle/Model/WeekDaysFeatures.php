<?php

namespace OvertimeBundle\Model;


class WeekDaysFeatures
{
    public function isWeekendDate($dateTime) {
        $date = date_format($dateTime,'Y-m-d');
        if(date('N', strtotime($date)) >= 6) {
            return true;
        } else {
            return false;
        }
    }

    public function isHolidayDate($dateTime) {
        $date = date_format($dateTime,'d-m');
        $year = date_format($dateTime, 'Y');
        $easter = date('d-m', easter_date($year));
        $mondayEaster = date($easter, strtotime("+1 day"));
        $corpusChristi = date($easter, strtotime("+60 days"));
        $holidays = array(
            '01-01',
            '06-01',
            $easter,
            $mondayEaster,
            $corpusChristi,
            '01-05',
            '03-05',
            '15-08',
            '01-11',
            '11-11',
            '25-12',
            '26-12',
        );

        if(in_array($date,$holidays)) {
            return true;
        } else {
            return false;
        }
    }

}