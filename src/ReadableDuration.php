<?php

namespace webignition\ReadableDuration;

class ReadableDuration
{
    const MAX_APPROPRIATE_UNITS_PRECISION = 6;

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
        Units::UNIT_MONTH => Durations::MONTHS_PER_YEAR,
        Units::UNIT_DAY => Durations::DAYS_PER_MONTH,
        Units::UNIT_HOUR => Durations::HOURS_PER_DAY,
        Units::UNIT_MINUTE => Durations::MINUTES_PER_HOUR,
        Units::UNIT_SECOND => Durations::SECONDS_PER_MINUTE
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
        Units::UNIT_YEAR => self::INTERVAL_YEAR_KEY,
        Units::UNIT_MONTH => self::INTERVAL_MONTH_KEY,
        Units::UNIT_DAY => self::INTERVAL_DAY_KEY,
        Units::UNIT_HOUR => self::INTERVAL_HOUR_KEY,
        Units::UNIT_MINUTE => self::INTERVAL_MINUTE_KEY,
        Units::UNIT_SECOND  => self::INTERVAL_SECOND_KEY,
    ];

    /**
     * @var array
     */
    private $unitIncremement = [
        Units::UNIT_SECOND => Units::UNIT_MINUTE,
        Units::UNIT_MINUTE => Units::UNIT_HOUR,
        Units::UNIT_HOUR => Units::UNIT_DAY,
        Units::UNIT_DAY => Units::UNIT_MONTH,
        Units::UNIT_MONTH => Units::UNIT_YEAR,
    ];

    /**
     * @var \DateTime
     */
    private $currentTime = null;

    /**
     * @var \DateTime
     */
    private $comparatorTime = null;

    public function __construct(?int $valueInSeconds = null)
    {
        if (is_int($valueInSeconds)) {
            $this->setValueInSeconds($valueInSeconds);
        }
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
        return (int) round($this->getInSeconds() / Durations::SECONDS_PER_YEAR);
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
        return (int) round($this->getInSeconds() / Durations::SECONDS_PER_MONTH);
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
        return (int) round($this->getInSeconds() / Durations::SECONDS_PER_DAY);
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
        return (int) round($this->getInSeconds() / Durations::SECONDS_PER_HOUR);
    }

    public function getMinutes(): int
    {
        return $this->interval->{self::INTERVAL_MINUTE_KEY};
    }

    public function getInMinutes(): int
    {
        return (int) round($this->getInSeconds() / Durations::SECONDS_PER_MINUTE);
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

        if (Units::UNIT_YEAR === $currentUnit) {
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
