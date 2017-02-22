<?php

namespace OvertimeBundle\Model;

include_once 'WeekDaysFeatures.php';
include_once 'ClassifiedOvertime.php';
class OvertimeClassifier
{
    public function classify($overtimeHours)
    {
        $classifiedHours = [];
        $classifiedHours[ClassifiedOvertime::weekDay] = new ClassifiedOvertime();
        $classifiedHours[ClassifiedOvertime::weekNight] = new ClassifiedOvertime();
        $classifiedHours[ClassifiedOvertime::holidayDay] = new ClassifiedOvertime();
        $classifiedHours[ClassifiedOvertime::holidayNight] = new ClassifiedOvertime();


        $timeIterator = clone $overtimeHours->getStartDate();
        $minutesToNextFullHour = 60 - intval($timeIterator->format('i'));
        $hourType = $this->getOvertimeType($timeIterator);
        $timeIterator->add(new \DateInterval('PT'.$minutesToNextFullHour.'M'));
        while($timeIterator <= $overtimeHours->getEndDate()) {
            $classifiedHours[$hourType]->addMinutes($minutesToNextFullHour);
            $hourType = $this->getOvertimeType($timeIterator);
            $minutesToNextFullHour = 60;
            $timeIterator->add(new \DateInterval('PT'.$minutesToNextFullHour.'M'));
        }
        $lastHourMinutes = intval($overtimeHours->getEndDate()->format('i'));
        $hourType = $this->getOvertimeType($overtimeHours->getEndDate());
        $classifiedHours[$hourType]->addMinutes($lastHourMinutes);
        return $classifiedHours;
    }

    public function getOvertimeType($date)
    {
        $weekDaysFeatures = new WeekDaysFeatures();
        $isHoliday = $weekDaysFeatures->isHolidayDate($date) || $weekDaysFeatures->isWeekendDate($date);
        $isDayHour = $this->isDayTimeHour($date);

        if($isHoliday) {
            if($isDayHour) {
                return ClassifiedOvertime::holidayDay;
            }
            return ClassifiedOvertime::holidayNight;
        } else {
            if($isDayHour) {
                return ClassifiedOvertime::weekDay;            }
            return ClassifiedOvertime::weekNight;
        }
    }

    public function isDayTimeHour($date)
    {
        $hour = intval($date->format('H'));

        if($hour>=6 && $hour<22) {
            return true;
        }
        return false;
    }
}