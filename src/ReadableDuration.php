<?php

namespace webignition\ReadableDuration;

class ReadableDuration
{
    const SECONDS_PER_MINUTE = 60;
    const MINUTES_PER_HOUR = 60;
    const HOURS_PER_DAY = 24;
    const DAYS_PER_MONTH = 30; // approximate!
    const MONTHS_PER_YEAR = 12;
    const DAYS_PER_YEAR = 365; // approximate!

    const SECONDS_PER_DAY = self::SECONDS_PER_MINUTE * self::MINUTES_PER_HOUR * self::HOURS_PER_DAY;
    const SECONDS_PER_HOUR = self::SECONDS_PER_MINUTE * self::MINUTES_PER_HOUR;
    const SECONDS_PER_YEAR = self::SECONDS_PER_DAY * self::DAYS_PER_YEAR;

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
    private $unitsToIntervalUnits = [
        self::UNIT_YEAR => self::INTERVAL_YEAR_KEY,
        self::UNIT_MONTH => self::INTERVAL_MONTH_KEY,
        self::UNIT_DAY => self::INTERVAL_DAY_KEY,
        self::UNIT_HOUR => self::INTERVAL_HOUR_KEY,
        self::UNIT_MINUTE => self::INTERVAL_MINUTE_KEY,
        self::UNIT_SECOND  => self::INTERVAL_SECOND_KEY,
    ];

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
     * @var float|int
     */
    private $secondsPerHour = self::SECONDS_PER_MINUTE * self::MINUTES_PER_HOUR;

    /**
     * @var float|int
     */
    private $secondsPerDay;

    /**
     * @var float|int
     */
    private $secondsPerMonth;

    /**
     * @var float|int
     */
    private $secondsPerYear;

    /**
     * @param int $valueInSeconds
     */
    public function __construct($valueInSeconds = null)
    {
//        $this->setValueInSeconds($valueInSeconds);

        $this->secondsPerDay = $this->secondsPerHour * self::HOURS_PER_DAY;
        $this->secondsPerMonth = $this->secondsPerDay * (self::DAYS_PER_YEAR / self::MONTHS_PER_YEAR);
        $this->secondsPerYear = $this->secondsPerDay * self::DAYS_PER_YEAR;
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

        if (0 === $this->valueInSeconds) {
            $this->comparatorTime = clone $this->currentTime;
        } else {
            $comparatorTime = clone $this->currentTime;
            $comparatorTime->modify('+'.$this->valueInSeconds.' second');

            $this->comparatorTime = $comparatorTime;

        }

        $this->interval = $this->currentTime->diff($this->comparatorTime);

        return $this;
    }

    /**
     * @return bool
     */
    public function isFuture()
    {
        if ($this->isPresent()) {
            return false;
        }

        return $this->interval->invert === 0;
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

        return $this->interval->invert === 1;
    }

    /**
     * @return int
     */
    public function getYears()
    {
        return $this->interval->{self::INTERVAL_YEAR_KEY};
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
        return (int)round($this->getInSeconds() / $this->secondsPerYear);
    }

    /**
     * @return int
     */
    public function getMonths()
    {
        return $this->interval->{self::INTERVAL_MONTH_KEY};
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
        return (int)round($this->getInSeconds() / $this->secondsPerMonth);
    }

    /**
     * @return int
     */
    public function getDays()
    {
        return $this->interval->{self::INTERVAL_DAY_KEY};
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
        return (int)round($this->getInSeconds() / $this->secondsPerDay);
    }

    /**
     * @return int
     */
    public function getHours()
    {
        return $this->interval->{self::INTERVAL_HOUR_KEY};
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
        return (int)round($this->getInSeconds() / $this->secondsPerHour);
    }

    /**
     * @return int
     */
    public function getMinutes()
    {
        return $this->interval->{self::INTERVAL_MINUTE_KEY};
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
        return $this->interval->{self::INTERVAL_SECOND_KEY};
    }

    /**
     * @return int
     */
    public function getInSeconds()
    {
        return $this->valueInSeconds;
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

        $values = [];

        for ($precisionLevel = 0; $precisionLevel < $precision; $precisionLevel++) {
            if ($precisionLevel == $precision - 1) {
                if ($this->getLargestIntervalUnit() == 'second') {
                    $methodName = 'getSeconds';
                } else {
                    $methodName = 'getRounded'.ucwords($this->getLargestIntervalUnit()).'s';
                }

                if ($this->$methodName() !== 0) {
                    $values[] = [
                        'unit' => $this->getLargestIntervalUnit(),
                        'value' => $this->$methodName()
                    ];
                }
            } else {
                $values[] = [
                    'unit' => $this->getLargestIntervalUnit(),
                    'value' => $this->interval->{$this->unitsToIntervalUnits[$this->getLargestIntervalUnit()]}
                ];
            }

            $this->interval->{$this->unitsToIntervalUnits[$this->getLargestIntervalUnit()]} = 0;
        }

        $this->interval = $this->currentTime->diff($this->comparatorTime);

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
        $intervalUnits = [
            'y' => 'year',
            'm' => 'month',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second'
        ];

        foreach ($intervalUnits as $intervalUnitKey => $unit) {
            if ($this->interval->$intervalUnitKey !== 0) {
                return $unit;
            }
        }

        return 'second';
    }
}
