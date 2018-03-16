<?php

namespace webignition\ReadableDuration;

class ReadableDuration
{
    const SECONDS_PER_MINUTE = 60;
    const MINUTES_PER_HOUR = 60;
    const HOURS_PER_DAY = 24;
    const DAYS_PER_MONTH = 30.44; // approximate!
    const MONTHS_PER_YEAR = 12;
    const DAYS_PER_YEAR = 365.25; // approximate!

    const MAX_APPROPRIATE_UNITS_PRECISION = 6;

    const UNIT_YEAR = 'year';
    const UNIT_MONTH = 'month';
    const UNIT_DAY = 'day';
    const UNIT_HOUR = 'hour';
    const UNIT_MINUTE = 'minute';
    const UNIT_SECOND = 'second';

    const INTERVAL_YEAR_KEY = 'y';
    const INTERVAL_MONTH_KEY = 'm';
    const INTERVAL_DAY_KEY = 'd';
    const INTERVAL_HOUR_KEY = 'h';
    const INTERVAL_MINUTE_KEY = 'i';
    const INTERVAL_SECOND_KEY = 's';

    /**
     * @var array
     */
    private $unitThresholds = [
        self::UNIT_MONTH => self::MONTHS_PER_YEAR,
        self::UNIT_DAY => self::DAYS_PER_MONTH,
        self::UNIT_HOUR => self::HOURS_PER_DAY,
        self::UNIT_MINUTE => self::MINUTES_PER_HOUR,
        self::UNIT_SECOND => self::SECONDS_PER_MINUTE
    ];

    /**
     * @var int
     */
    private $valueInSeconds = 0;

    /**
     * @var \DateInterval
     */
    private $interval = null;

    /**
     * @var array
     */
    private $unitsToIntervalUnits = array(
        self::UNIT_YEAR => self::INTERVAL_YEAR_KEY,
        self::UNIT_MONTH => self::INTERVAL_MONTH_KEY,
        self::UNIT_DAY => self::INTERVAL_DAY_KEY,
        self::UNIT_HOUR => self::INTERVAL_HOUR_KEY,
        self::UNIT_MINUTE => self::INTERVAL_MINUTE_KEY,
        self::UNIT_SECOND  => self::INTERVAL_SECOND_KEY,
    );

    /**
     * @var array
     */
    private $unitIncremement = [
        self::UNIT_SECOND => self::UNIT_MINUTE,
        self::UNIT_MINUTE => self::UNIT_HOUR,
        self::UNIT_HOUR => self::UNIT_DAY,
        self::UNIT_DAY => self::UNIT_MONTH,
        self::UNIT_MONTH => self::UNIT_YEAR,
    ];

    /**
     * @var \DateTime
     */
    private $currentTime = null;

    /**
     * @var \DateTime
     */
    private $comparatorTime = null;

    /**
     * @param int $valueInSeconds
     */
    public function __construct($valueInSeconds = null)
    {
        $this->setValueInSeconds($valueInSeconds);
    }

    /**
     * @param int $valueInSeconds
     *
     * @return ReadableDuration
     */
    public function setValueInSeconds($valueInSeconds)
    {
        if (!is_scalar($valueInSeconds)) {
            $valueInSeconds = 0;
        } else {
            $valueInSeconds = (int)$valueInSeconds;
        }

        $this->valueInSeconds = $valueInSeconds;

        $this->currentTime = new \DateTime();

        if ($this->valueInSeconds === 0) {
            $this->comparatorTime = clone $this->currentTime;
        } else {
            $this->comparatorTime = new \DateTime('+'.$this->valueInSeconds.' second');
        }

        return $this;
    }

    /**
     * @return \DateInterval
     */
    private function getInterval()
    {
        if (is_null($this->interval)) {
            $this->interval = $this->currentTime->diff($this->comparatorTime);
        }

        return $this->interval;
    }

    /**
     * @return bool
     */
    public function isFuture()
    {
        if ($this->isPresent()) {
            return false;
        }

        return $this->getInterval()->invert === 0;
    }

    /**
     * @return bool
     */
    public function isPresent()
    {
        return $this->getInSeconds() === 0;
    }

    /**
     * @return bool
     */
    public function isPast()
    {
        if ($this->isPresent()) {
            return false;
        }

        return $this->getInterval()->invert === 1;
    }

    /**
     * @return int
     */
    public function getYears()
    {
        return $this->getInterval()->{self::INTERVAL_YEAR_KEY};
    }

    /**
     * @return int
     */
    public function getRoundedYears()
    {
        $years = $this->getYears();
        $months = $this->getMonths();

        if ($months <= 6) {
            return $years;
        }

        return $years + 1;
    }

    /**
     * @return int
     */
    public function getInYears()
    {
        return (int)round($this->getInSeconds() / $this->getSecondsPerYear());
    }

    /**
     * @return int
     */
    public function getMonths()
    {
        return $this->getInterval()->{self::INTERVAL_MONTH_KEY};
    }

    /**
     * @return int
     */
    public function getRoundedMonths()
    {
        $months = $this->getMonths();
        $days = $this->getDays();


        if ($days <= 15) {
            return $months;
        }

        return $months + 1;
    }

    /**
     * @return float
     */
    public function getInMonths()
    {
        return (int)round($this->getInSeconds() / $this->getSecondsPerMonth());
    }

    /**
     * @return int
     */
    public function getDays()
    {
        return $this->getInterval()->{self::INTERVAL_DAY_KEY};
    }

    /**
     * @return int
     */
    public function getRoundedDays()
    {
        $days = $this->getDays();
        $hours = $this->getHours();

        if ($hours <= 11) {
            return $days;
        }

        return $days + 1;
    }

    /**
     * @return float
     */
    public function getInDays()
    {
        return (int)round($this->getInSeconds() / $this->getSecondsPerDay());
    }

    /**
     * @return int
     */
    public function getHours()
    {
        return $this->getInterval()->{self::INTERVAL_HOUR_KEY};
    }

    /**
     * @return int
     */
    public function getRoundedHours()
    {
        $hours = $this->getHours();
        $minutes = $this->getMinutes();

        if ($minutes <= 29) {
            return $hours;
        }

        return $hours + 1;
    }

    /**
     * @return float
     */
    public function getInHours()
    {
        return (int)round($this->getInSeconds() / $this->getSecondsPerHour());
    }

    /**
     * @return int
     */
    public function getMinutes()
    {
        return $this->getInterval()->{self::INTERVAL_MINUTE_KEY};
    }

    /**
     * @return float
     */
    public function getInMinutes()
    {
        return (int)round($this->getInSeconds() / self::SECONDS_PER_MINUTE);
    }

    /**
     * @return int
     */
    public function getRoundedMinutes()
    {
        $minutes = $this->getMinutes();
        $seconds = $this->getSeconds();

        if ($seconds <= 29) {
            return $minutes;
        }

        return $minutes + 1;
    }

    /**
     * @return int
     */
    public function getSeconds()
    {
        return $this->getInterval()->{self::INTERVAL_SECOND_KEY};
    }

    /**
     * @return int
     */
    public function getInSeconds()
    {
        return $this->valueInSeconds;
    }

    /**
     * @return int
     */
    private function getSecondsPerHour()
    {
        return self::SECONDS_PER_MINUTE * self::MINUTES_PER_HOUR;
    }

    /**
     * @return int
     */
    private function getSecondsPerDay()
    {
        return $this->getSecondsPerHour() * self::HOURS_PER_DAY;
    }

    /**
     * @return int
     */
    private function getSecondsPerMonth()
    {
        return $this->getSecondsPerDay() * (self::DAYS_PER_YEAR / self::MONTHS_PER_YEAR);
    }

    /**
     * @return int
     */
    private function getSecondsPerYear()
    {
        return $this->getSecondsPerDay() * self::DAYS_PER_YEAR;
    }

    /**
     * @param int $precision
     *
     * @return array
     */
    public function getInMostAppropriateUnits($precision = 1)
    {
        if (!is_scalar($precision)) {
            $precision = 1;
        }

        $precision = (int)round($precision);

        if ($precision > self::MAX_APPROPRIATE_UNITS_PRECISION) {
            $precision = self::MAX_APPROPRIATE_UNITS_PRECISION;
        }

        $values = array();

        for ($precisionLevel = 0; $precisionLevel < $precision; $precisionLevel++) {
            if ($precisionLevel == $precision - 1) {
                if ($this->getLargestIntervalUnit() == 'second') {
                    $methodName = 'getSeconds';
                } else {
                    $methodName = 'getRounded'.ucwords($this->getLargestIntervalUnit()).'s';
                }

                if ($this->$methodName() !== 0) {
                    $values[] = array(
                        'unit' => $this->getLargestIntervalUnit(),
                        'value' => $this->$methodName()
                    );
                }
            } else {
                $values[] = array(
                    'unit' => $this->getLargestIntervalUnit(),
                    'value' => $this->getInterval()->{$this->unitsToIntervalUnits[$this->getLargestIntervalUnit()]}
                );
            }

            $this->getInterval()->{$this->unitsToIntervalUnits[$this->getLargestIntervalUnit()]} = 0;
        }

        $this->interval = null;

        $valueCount = count($values);

        if (1 === $valueCount) {
            $values = $this->roundUpUnitValues($values);
        }

        return $values;
    }

    /**
     * @param array $unitValues
     *
     * @return array
     */
    private function roundUpUnitValues($unitValues)
    {
        $unitValue = $unitValues[0];
        $currentUnit = $unitValue['unit'];
        $currentValue = $unitValue['value'];

        if (self::UNIT_YEAR === $currentUnit) {
            return $unitValues;
        }

        if ($this->isApproachingThreshold($currentValue, $currentUnit)) {
            return [
                [
                    'unit' => $this->unitIncremement[$currentUnit],
                    'value' => 1,
                ],
            ];
        }

        return $unitValues;
    }

    /**
     * @param float|int $value
     * @param string $unit
     *
     * @return bool
     */
    private function isApproachingThreshold($value, $unit)
    {
        return round($value) == round($this->unitThresholds[$unit]);
    }

    /**
     * @return string
     */
    private function getLargestIntervalUnit()
    {
        $intervalUnits = array(
            'y' => 'year',
            'm' => 'month',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second'
        );
        foreach ($intervalUnits as $intervalUnitKey => $unit) {
            if ($this->getInterval()->$intervalUnitKey !== 0) {
                return $unit;
            }
        }

        return 'second';
    }
}
