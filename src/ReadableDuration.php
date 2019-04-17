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
    const SECONDS_PER_MONTH = self::SECONDS_PER_DAY * self::DAYS_PER_MONTH;

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
    private $secondsPerMonth;

    /**
     * @var float|int
     */
    private $secondsPerYear;

    public function __construct(?int $valueInSeconds = null)
    {
        if (is_int($valueInSeconds)) {
            $this->setValueInSeconds($valueInSeconds);
        }

        $this->secondsPerMonth = self::SECONDS_PER_DAY * (self::DAYS_PER_YEAR / self::MONTHS_PER_YEAR);
        $this->secondsPerYear = self::SECONDS_PER_DAY * self::DAYS_PER_YEAR;
    }

    public function setValueInSeconds(int $valueInSeconds): ReadableDuration
    {
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

    public function isFuture(): bool
    {
        if ($this->isPresent()) {
            return false;
        }

        return $this->interval->invert === 0;
    }

    public function isPresent(): bool
    {
        return $this->getInSeconds() === 0;
    }

    public function isPast(): bool
    {
        if ($this->isPresent()) {
            return false;
        }

        return $this->interval->invert === 1;
    }

    public function getYears(): int
    {
        return $this->interval->{self::INTERVAL_YEAR_KEY};
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
        return (int) round($this->getInSeconds() / $this->secondsPerYear);
    }

    public function getMonths(): int
    {
        return $this->interval->{self::INTERVAL_MONTH_KEY};
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
        return (int) round($this->getInSeconds() / $this->secondsPerMonth);
    }

    public function getDays(): int
    {
        return $this->interval->{self::INTERVAL_DAY_KEY};
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
        return (int) round($this->getInSeconds() / self::SECONDS_PER_DAY);
    }

    public function getHours(): int
    {
        return $this->interval->{self::INTERVAL_HOUR_KEY};
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
        return (int) round($this->getInSeconds() / self::SECONDS_PER_HOUR);
    }

    public function getMinutes(): int
    {
        return $this->interval->{self::INTERVAL_MINUTE_KEY};
    }

    public function getInMinutes(): int
    {
        return (int) round($this->getInSeconds() / self::SECONDS_PER_MINUTE);
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
        return $this->interval->{self::INTERVAL_SECOND_KEY};
    }

    public function getInSeconds(): int
    {
        return $this->valueInSeconds;
    }

    public function getInMostAppropriateUnits(int $precision = 1): array
    {
        $precision = (int) round($precision);

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

    private function roundUpUnitValues(array $unitValues): array
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
    private function isApproachingThreshold($value, string $unit): bool
    {
        return round($value) == round($this->unitThresholds[$unit]);
    }

    private function getLargestIntervalUnit(): string
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
