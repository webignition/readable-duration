<?php

namespace webignition\ReadableDuration;

class ReadableDuration
{
    private $valueInSeconds = 0;
    private $interval = null;

    public function __construct(int $valueInSeconds, \DateInterval $dateInterval)
    {
        $this->valueInSeconds = $valueInSeconds;
        $this->interval = $dateInterval;
    }

    public function getDateInterval(): \DateInterval
    {
        return $this->interval;
    }

    public function isFuture(): bool
    {
        return $this->isPresent() ? false : $this->interval->invert === 0;
    }

    public function isPresent(): bool
    {
        return $this->valueInSeconds === 0;
    }

    public function isPast(): bool
    {
        return $this->isPresent() ? false : $this->interval->invert === 1;
    }

    public function getYears(): int
    {
        return $this->interval->{IntervalKeys::YEAR};
    }

    public function getRoundedYears(): int
    {
        $years = $this->getYears();
        $months = $this->getMonths();

        if ($months <= 6) {
            return $years;
        }

        return $years + 1;
    }

    public function getInYears(): int
    {
        return (int) round($this->valueInSeconds / Durations::SECONDS_PER_YEAR);
    }

    public function getMonths(): int
    {
        return $this->interval->{IntervalKeys::MONTH};
    }

    public function getRoundedMonths(): int
    {
        $months = $this->getMonths();
        $days = $this->getDays();

        if ($days <= 15) {
            return $months;
        }

        return $months + 1;
    }

    public function getInMonths(): int
    {
        return (int) round($this->valueInSeconds / Durations::SECONDS_PER_MONTH);
    }

    public function getDays(): int
    {
        return $this->interval->{IntervalKeys::DAY};
    }

    public function getRoundedDays(): int
    {
        $days = $this->getDays();
        $hours = $this->getHours();

        if ($hours <= 11) {
            return $days;
        }

        return $days + 1;
    }

    public function getInDays(): int
    {
        return (int) round($this->valueInSeconds / Durations::SECONDS_PER_DAY);
    }

    public function getHours(): int
    {
        return $this->interval->{IntervalKeys::HOUR};
    }

    public function getRoundedHours(): int
    {
        $hours = $this->getHours();
        $minutes = $this->getMinutes();

        if ($minutes <= 29) {
            return $hours;
        }

        return $hours + 1;
    }

    public function getInHours(): int
    {
        return (int) round($this->valueInSeconds / Durations::SECONDS_PER_HOUR);
    }

    public function getMinutes(): int
    {
        return $this->interval->{IntervalKeys::MINUTE};
    }

    public function getInMinutes(): int
    {
        return (int) round($this->valueInSeconds / Durations::SECONDS_PER_MINUTE);
    }

    public function getRoundedMinutes(): int
    {
        $minutes = $this->getMinutes();
        $seconds = $this->getSeconds();

        if ($seconds <= 29) {
            return $minutes;
        }

        return $minutes + 1;
    }

    public function getSeconds(): int
    {
        return $this->interval->{IntervalKeys::SECOND};
    }

    public function getInSeconds(): int
    {
        return $this->valueInSeconds;
    }
}
