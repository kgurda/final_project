<?php


namespace OvertimeBundle\Model;


class ClassifiedOvertime
{
    const weekDay = 0;
    const weekNight = 1;
    const holidayDay = 2;
    const holidayNight = 3;

    private $durationMinutes;

    public function __construct()
    {
        $this->durationMinutes=0;
    }

    public function getDurationMinutes()
    {
        return $this->durationMinutes;
    }

    public function addMinutes($minutes)
    {
        $this->durationMinutes+=$minutes;
    }

    public function __toString()
    {
        $hours = floor($this->durationMinutes/60);
        $minutes = $this->durationMinutes%60;
        return $hours.' hours, '.$minutes.' minutes';
    }
}