<?php

namespace webignition\ReadableDuration;

class Factory
{
    const MAX_APPROPRIATE_UNITS_PRECISION = 6;

    private $unitThresholds = [
        Units::UNIT_MONTH => Durations::MONTHS_PER_YEAR,
        Units::UNIT_DAY => Durations::DAYS_PER_MONTH,
        Units::UNIT_HOUR => Durations::HOURS_PER_DAY,
        Units::UNIT_MINUTE => Durations::MINUTES_PER_HOUR,
        Units::UNIT_SECOND => Durations::SECONDS_PER_MINUTE
    ];

    private $unitsToIntervalKeys = [
        Units::UNIT_YEAR => IntervalKeys::YEAR,
        Units::UNIT_MONTH => IntervalKeys::MONTH,
        Units::UNIT_DAY => IntervalKeys::DAY,
        Units::UNIT_HOUR => IntervalKeys::HOUR,
        Units::UNIT_MINUTE => IntervalKeys::MINUTE,
        Units::UNIT_SECOND  => IntervalKeys::SECOND,
    ];

    private $intervalKeysToUnits = [
        IntervalKeys::YEAR => Units::UNIT_YEAR,
        IntervalKeys::MONTH => Units::UNIT_MONTH,
        IntervalKeys::DAY => Units::UNIT_DAY ,
        IntervalKeys::HOUR => Units::UNIT_HOUR,
        IntervalKeys::MINUTE => Units::UNIT_MINUTE,
        IntervalKeys::SECOND => Units::UNIT_SECOND
    ];

    private $unitIncrement = [
        Units::UNIT_SECOND => Units::UNIT_MINUTE,
        Units::UNIT_MINUTE => Units::UNIT_HOUR,
        Units::UNIT_HOUR => Units::UNIT_DAY,
        Units::UNIT_DAY => Units::UNIT_MONTH,
        Units::UNIT_MONTH => Units::UNIT_YEAR,
    ];

    public function create(int $valueInSeconds): ReadableDurationResult
    {
        $currentTime = new \DateTime();
        $comparatorTime = clone $currentTime;

        if ($valueInSeconds !== 0) {
            $comparatorTime->modify('+' . $valueInSeconds . ' second');
        }

        $dateInterval = $currentTime->diff($comparatorTime);

        return new ReadableDurationResult($valueInSeconds, $dateInterval);
    }

    public function getInMostAppropriateUnits(ReadableDurationResult $readableDuration, int $precision = 1): array
    {
        $workingReadableDuration = clone $readableDuration;
        $interval = clone $readableDuration->getDateInterval();

        $precision = (int) round($precision);

        if ($precision > self::MAX_APPROPRIATE_UNITS_PRECISION) {
            $precision = self::MAX_APPROPRIATE_UNITS_PRECISION;
        }

        $values = [];

        for ($precisionLevel = 0; $precisionLevel < $precision; $precisionLevel++) {
            if ($precisionLevel == $precision - 1) {
                if ($this->getLargestIntervalUnit($interval) == 'second') {
                    $methodName = 'getSeconds';
                } else {
                    $methodName = 'getRounded'.ucwords($this->getLargestIntervalUnit($interval)).'s';
                }

                if ($workingReadableDuration->$methodName() !== 0) {
                    $values[] = [
                        'unit' => $this->getLargestIntervalUnit($interval),
                        'value' => $workingReadableDuration->$methodName()
                    ];
                }
            } else {
                $values[] = [
                    'unit' => $this->getLargestIntervalUnit($interval),
                    'value' => $interval->{$this->unitsToIntervalKeys[$this->getLargestIntervalUnit($interval)]}
                ];
            }

            $interval->{$this->unitsToIntervalKeys[$this->getLargestIntervalUnit($interval)]} = 0;

            $workingReadableDuration = new ReadableDurationResult(
                $workingReadableDuration->getInSeconds(),
                $interval
            );
        }

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
                    'unit' => $this->unitIncrement[$currentUnit],
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

    private function getLargestIntervalUnit(\DateInterval $interval): string
    {
        foreach ($this->intervalKeysToUnits as $intervalKey => $unit) {
            if ($interval->$intervalKey !== 0) {
                return $unit;
            }
        }

        return Units::UNIT_SECOND;
    }
}