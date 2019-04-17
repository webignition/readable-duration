<?php

namespace webignition\ReadableDuration;

class Factory
{
    const MAX_APPROPRIATE_UNITS_PRECISION = 6;

//    /**
//     * @var array
//     */
//    private $unitThresholds = [
//        Units::UNIT_MONTH => Durations::MONTHS_PER_YEAR,
//        Units::UNIT_DAY => Durations::DAYS_PER_MONTH,
//        Units::UNIT_HOUR => Durations::HOURS_PER_DAY,
//        Units::UNIT_MINUTE => Durations::MINUTES_PER_HOUR,
//        Units::UNIT_SECOND => Durations::SECONDS_PER_MINUTE
//    ];
//
//    /**
//     * @var array
//     */
//    private $unitsToIntervalUnits = [
//        Units::UNIT_YEAR => IntervalKeys::YEAR,
//        Units::UNIT_MONTH => IntervalKeys::MONTH,
//        Units::UNIT_DAY => IntervalKeys::DAY,
//        Units::UNIT_HOUR => IntervalKeys::HOUR,
//        Units::UNIT_MINUTE => IntervalKeys::MINUTE,
//        Units::UNIT_SECOND  => IntervalKeys::SECOND,
//    ];
//
//    /**
//     * @var array
//     */
//    private $unitIncremement = [
//        Units::UNIT_SECOND => Units::UNIT_MINUTE,
//        Units::UNIT_MINUTE => Units::UNIT_HOUR,
//        Units::UNIT_HOUR => Units::UNIT_DAY,
//        Units::UNIT_DAY => Units::UNIT_MONTH,
//        Units::UNIT_MONTH => Units::UNIT_YEAR,
//    ];

    public function create(int $valueInSeconds)
    {
        $currentTime = new \DateTime();
        $comparatorTime = clone $currentTime;

        if ($valueInSeconds !== 0) {
            $comparatorTime->modify('+' . $valueInSeconds . ' second');
        }

        $dateInterval = $currentTime->diff($comparatorTime);

        return new ReadableDurationResult($valueInSeconds, $dateInterval);
    }

//    public function getInMostAppropriateUnits(int $precision = 1): array
//    {
//        $precision = (int) round($precision);
//
//        if ($precision > self::MAX_APPROPRIATE_UNITS_PRECISION) {
//            $precision = self::MAX_APPROPRIATE_UNITS_PRECISION;
//        }
//
//        $values = [];
//
//        for ($precisionLevel = 0; $precisionLevel < $precision; $precisionLevel++) {
//            if ($precisionLevel == $precision - 1) {
//                if ($this->getLargestIntervalUnit() == 'second') {
//                    $methodName = 'getSeconds';
//                } else {
//                    $methodName = 'getRounded'.ucwords($this->getLargestIntervalUnit()).'s';
//                }
//
//                if ($this->$methodName() !== 0) {
//                    $values[] = [
//                        'unit' => $this->getLargestIntervalUnit(),
//                        'value' => $this->$methodName()
//                    ];
//                }
//            } else {
//                $values[] = [
//                    'unit' => $this->getLargestIntervalUnit(),
//                    'value' => $this->interval->{$this->unitsToIntervalUnits[$this->getLargestIntervalUnit()]}
//                ];
//            }
//
//            $this->interval->{$this->unitsToIntervalUnits[$this->getLargestIntervalUnit()]} = 0;
//        }
//
//        $this->interval = $this->currentTime->diff($this->comparatorTime);
//
//        $valueCount = count($values);
//
//        if (1 === $valueCount) {
//            $values = $this->roundUpUnitValues($values);
//        }
//
//        return $values;
//    }
//
//    private function roundUpUnitValues(array $unitValues): array
//    {
//        $unitValue = $unitValues[0];
//        $currentUnit = $unitValue['unit'];
//        $currentValue = $unitValue['value'];
//
//        if (Units::UNIT_YEAR === $currentUnit) {
//            return $unitValues;
//        }
//
//        if ($this->isApproachingThreshold($currentValue, $currentUnit)) {
//            return [
//                [
//                    'unit' => $this->unitIncremement[$currentUnit],
//                    'value' => 1,
//                ],
//            ];
//        }
//
//        return $unitValues;
//    }
//
//    /**
//     * @param float|int $value
//     * @param string $unit
//     *
//     * @return bool
//     */
//    private function isApproachingThreshold($value, string $unit): bool
//    {
//        return round($value) == round($this->unitThresholds[$unit]);
//    }
//
//    private function getLargestIntervalUnit(): string
//    {
//        $intervalUnits = [
//            'y' => 'year',
//            'm' => 'month',
//            'd' => 'day',
//            'h' => 'hour',
//            'i' => 'minute',
//            's' => 'second'
//        ];
//
//        foreach ($intervalUnits as $intervalUnitKey => $unit) {
//            if ($this->interval->$intervalUnitKey !== 0) {
//                return $unit;
//            }
//        }
//
//        return 'second';
//    }
}
