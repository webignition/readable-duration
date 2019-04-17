<?php

namespace webignition\Tests\ReadableDuration;

use webignition\ReadableDuration\ReadableDuration;

class ReadableDurationTest extends AbstractReadableDurationTest
{
    /**
     * @dataProvider setValueInSecondsGetInSecondsDataProvider
     *
     * @param int $valueInSeconds
     * @param int $expectedSeconds
     */
    public function testSetValueInSecondsGetInSeconds($valueInSeconds, $expectedSeconds)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedSeconds, $this->readableDuration->getInSeconds());
    }

    /**
     * @return array
     */
    public function setValueInSecondsGetInSecondsDataProvider()
    {
        return [
            'non-scalar' => [
                'valueInSeconds' => [],
                'expectedSeconds' => 0,
            ],
            'zero' => [
                'valueInSeconds' => 0,
                'expectedSeconds' => 0,
            ],
            'zero as string' => [
                'valueInSeconds' => '0',
                'expectedSeconds' => 0,
            ],
            'negative' => [
                'valueInSeconds' => -1,
                'expectedSeconds' => -1,
            ],
            'positive' => [
                'valueInSeconds' => 1,
                'expectedSeconds' => 1,
            ],
        ];
    }

    /**
     * @dataProvider isFutureDataProvider
     *
     * @param int $valueInSeconds
     * @param bool $expectedIsPast
     * @param bool $expectedIsPresent
     * @param bool $expectedIsFuture
     */
    public function testIsPastIsPresentIsFuture($valueInSeconds, $expectedIsPast, $expectedIsPresent, $expectedIsFuture)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedIsPast, $this->readableDuration->isPast());
        $this->assertEquals($expectedIsPresent, $this->readableDuration->isPresent());
        $this->assertEquals($expectedIsFuture, $this->readableDuration->isFuture());
    }

    /**
     * @return array
     */
    public function isFutureDataProvider()
    {
        return [
            'now' => [
                'valueInSeconds' => 0,
                'expectedIsPast' => false,
                'expectedIsPresent' => true,
                'expectedIsFuture' => false,
            ],
            'past' => [
                'valueInSeconds' => -1,
                'expectedIsPast' => true,
                'expectedIsPresent' => false,
                'expectedIsFuture' => false,
            ],
            'future' => [
                'valueInSeconds' => 1,
                'expectedIsPast' => false,
                'expectedIsPresent' => false,
                'expectedIsFuture' => true,
            ],
        ];
    }

    /**
     * @dataProvider getYearsDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedYears
     */
    public function testGetYears($valueInSeconds, $expectedYears)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedYears, $this->readableDuration->getYears());
    }

    /**
     * @return array
     */
    public function getYearsDataProvider()
    {
        $oneYearInSeconds = 366 * 86400;
        $twoYearsInSeconds = $oneYearInSeconds * 2;

        return [
            'zero seconds is zero years' => [
                'valueInSeconds' => 0,
                'expectedYears' => 0,
            ],
            '3600 seconds is zero years' => [
                'valueInSeconds' => 3600,
                'expectedYears' => 0,
            ],
            '-3600 seconds is zero years' => [
                'valueInSeconds' => -3600,
                'expectedYears' => 0,
            ],
            '+1 year in seconds is one year' => [
                'valueInSeconds' => $oneYearInSeconds,
                'expectedYears' => 1,
            ],
            '-1 year in seconds is one year' => [
                'valueInSeconds' => ($oneYearInSeconds * -1),
                'expectedYears' => 1,
            ],
            '+2 years in seconds is two years' => [
                'valueInSeconds' => $twoYearsInSeconds,
                'expectedYears' => 2,
            ],
            '-2 years in seconds is two years' => [
                'valueInSeconds' => ($twoYearsInSeconds + 1 * -1),
                'expectedYears' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getRoundedYearsDataProvider
     *
     * @param int $valueInSeconds
     * @param int $expectedRoundedYears
     */
    public function testGetRoundedYears($valueInSeconds, $expectedRoundedYears)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedRoundedYears, $this->readableDuration->getRoundedYears());
    }

    /**
     * @return array
     */
    public function getRoundedYearsDataProvider()
    {
        $oneYearInSeconds = 366 * 86400;
        $sixMonthsInSeconds = $oneYearInSeconds / 2;
        $twoYearsInSeconds = $oneYearInSeconds * 2;

        return [
            'zero seconds is zero years' => [
                'valueInSeconds' => 0,
                'expectedRoundedYears' => 0,
            ],
            '3600 seconds is zero years' => [
                'valueInSeconds' => 3600,
                'expectedRoundedYears' => 0,
            ],
            '-3600 seconds is zero years' => [
                'valueInSeconds' => -3600,
                'expectedRoundedYears' => 0,
            ],
            '6 months in seconds is zero years' => [
                'valueInSeconds' => $sixMonthsInSeconds,
                'expectedRoundedYears' => 0,
            ],
            'more than 6 months in seconds is one year' => [
                'valueInSeconds' => $sixMonthsInSeconds + ($sixMonthsInSeconds / 2),
                'expectedRoundedYears' => 1,
            ],
            '-6 months in seconds is zero years' => [
                'valueInSeconds' => $sixMonthsInSeconds * -1,
                'expectedRoundedYears' => 0,
            ],
            '-more than 6 months in seconds is one year' => [
                'valueInSeconds' => (($sixMonthsInSeconds + ($sixMonthsInSeconds / 2)) * -1),
                'expectedRoundedYears' => 1,
            ],
            '+1 year in seconds is one year' => [
                'valueInSeconds' => $oneYearInSeconds,
                'expectedRoundedYears' => 1,
            ],
            '+2 years in seconds is two years' => [
                'valueInSeconds' => $twoYearsInSeconds,
                'expectedRoundedYears' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getInYearsDataProvider
     *
     * @param int $valueInSeconds
     * @param int $expectedYears
     */
    public function testGetInYears($valueInSeconds, $expectedYears)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedYears, $this->readableDuration->getInYears());
    }

    /**
     * @return array
     */
    public function getInYearsDataProvider()
    {
        $oneYearInSeconds = 366 * 86400;
        $sixMonthsInSeconds = $oneYearInSeconds / 2;
        $twoYearsInSeconds = $oneYearInSeconds * 2;

        return [
            'zero seconds is zero years' => [
                'valueInSeconds' => 0,
                'expectedYears' => 0,
            ],
            '3600 seconds is zero years' => [
                'valueInSeconds' => 3600,
                'expectedYears' => 0,
            ],
            '-3600 seconds is zero years' => [
                'valueInSeconds' => -3600,
                'expectedYears' => 0,
            ],
            '6 months in seconds is one year' => [
                'valueInSeconds' => $sixMonthsInSeconds,
                'expectedYears' => 1
            ],
            'more than 6 months in seconds is one year' => [
                'valueInSeconds' => $sixMonthsInSeconds + ($sixMonthsInSeconds / 2),
                'expectedYears' => 1,
            ],
            '-6 months in seconds is -1 years' => [
                'valueInSeconds' => $sixMonthsInSeconds * -1,
                'expectedYears' => -1,
            ],
            '-more than 6 months in seconds is -1 year' => [
                'valueInSeconds' => (($sixMonthsInSeconds + ($sixMonthsInSeconds / 2)) * -1),
                'expectedYears' => -1,
            ],
            '+1 year in seconds is one year' => [
                'valueInSeconds' => $oneYearInSeconds,
                'expectedYears' => 1,
            ],
            '+2 years in seconds is two years' => [
                'valueInSeconds' => $twoYearsInSeconds,
                'expectedYears' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getMonthsDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedMonths
     */
    public function testGetMonths($valueInSeconds, $expectedMonths)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedMonths, $this->readableDuration->getMonths());
    }

    /**
     * @return array
     */
    public function getMonthsDataProvider()
    {
        $oneMonthInSeconds = 86400 * 31;

        return [
            'zero seconds is zero months' => [
                'valueInSeconds' => 0,
                'expectedMonths' => 0,
            ],
            '1 month in seconds is 1 month' => [
                'valueInSeconds' => $oneMonthInSeconds,
                'expectedMonths' => 1,
            ],
            '-1 month in seconds is 1 month' => [
                'valueInSeconds' => $oneMonthInSeconds * -1,
                'expectedMonths' => 1,
            ],
            '2 months in seconds is 2 months' => [
                'valueInSeconds' => ($oneMonthInSeconds * 2),
                'expectedMonths' => 2,
            ],
            '-2 months in seconds is -2 months' => [
                'valueInSeconds' => $oneMonthInSeconds * 2 * -1,
                'expectedMonths' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getRoundedMonthsDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedRoundedMonths
     */
    public function testGetRoundedMonths($valueInSeconds, $expectedRoundedMonths)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedRoundedMonths, $this->readableDuration->getRoundedMonths());
    }

    /**
     * @return array
     */
    public function getRoundedMonthsDataProvider()
    {
        $oneMonthInSeconds = 86400 * 31;

        return [
            'zero seconds is zero roundedMonths' => [
                'valueInSeconds' => 0,
                'expectedRoundedMonths' => 0,
            ],
            '0.8 month in seconds is 1 month' => [
                'valueInSeconds' => $oneMonthInSeconds * 0.8,
                'expectedRoundedMonths' => 1,
            ],
            '1 month in seconds is 1 month' => [
                'valueInSeconds' => $oneMonthInSeconds,
                'expectedRoundedMonths' => 1,
            ],
            '1.1 month in seconds is 1 month' => [
                'valueInSeconds' => $oneMonthInSeconds * 1.1,
                'expectedRoundedMonths' => 1,
            ],
            '-1 month in seconds is 1 month' => [
                'valueInSeconds' => $oneMonthInSeconds * -1,
                'expectedRoundedMonths' => 1,
            ],
        ];
    }

    /**
     * @dataProvider getInMonthsDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedInMonths
     */
    public function testGetInMonths($valueInSeconds, $expectedInMonths)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedInMonths, $this->readableDuration->getInMonths());
    }

    /**
     * @return array
     */
    public function getInMonthsDataProvider()
    {
        $oneMonthInSeconds = 86400 * 31;

        return [
            'zero seconds is zero inMonths' => [
                'valueInSeconds' => 0,
                'expectedInMonths' => 0,
            ],
            '1 month in seconds is 1 month' => [
                'valueInSeconds' => $oneMonthInSeconds,
                'expectedInMonths' => 1,
            ],
            '-1 month in seconds is 1 month' => [
                'valueInSeconds' => $oneMonthInSeconds * -1,
                'expectedInMonths' => -1,
            ],
            '2 inMonths in seconds is 2 months' => [
                'valueInSeconds' => ($oneMonthInSeconds * 2),
                'expectedInMonths' => 2,
            ],
            '-2 inMonths in seconds is 2 months' => [
                'valueInSeconds' => $oneMonthInSeconds * 2 * -1,
                'expectedInMonths' => -2,
            ],
        ];
    }

    /**
     * @dataProvider getDaysDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedDays
     */
    public function testGetDays($valueInSeconds, $expectedDays)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedDays, $this->readableDuration->getDays());
    }

    /**
     * @return array
     */
    public function getDaysDataProvider()
    {
        $oneDayInSeconds = 86400;

        return [
            'zero seconds is zero days' => [
                'valueInSeconds' => 0,
                'expectedDays' => 0,
            ],
            '1 day in seconds is 1 day' => [
                'valueInSeconds' => $oneDayInSeconds,
                'expectedDays' => 1,
            ],
            '-1 day in seconds is 1 day' => [
                'valueInSeconds' => $oneDayInSeconds * -1,
                'expectedDays' => 1,
            ],
            '2 days in seconds is 2 days' => [
                'valueInSeconds' => ($oneDayInSeconds * 2),
                'expectedDays' => 2,
            ],
            '-2 days in seconds is -2 days' => [
                'valueInSeconds' => $oneDayInSeconds * 2 * -1,
                'expectedDays' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getRoundedDaysDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedRoundedDays
     */
    public function testGetRoundedDays($valueInSeconds, $expectedRoundedDays)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedRoundedDays, $this->readableDuration->getRoundedDays());
    }

    /**
     * @return array
     */
    public function getRoundedDaysDataProvider()
    {
        $oneDayInSeconds = 86400;

        return [
            'zero seconds is zero days' => [
                'valueInSeconds' => 0,
                'expectedRoundedDays' => 0,
            ],
            '0.8 days in seconds is 1 day' => [
                'valueInSeconds' => $oneDayInSeconds * 0.8,
                'expectedRoundedDays' => 1,
            ],
            '1 day in seconds is 1 day' => [
                'valueInSeconds' => $oneDayInSeconds,
                'expectedRoundedDays' => 1,
            ],
            '1.1 day in seconds is 1 day' => [
                'valueInSeconds' => $oneDayInSeconds * 1.1,
                'expectedRoundedDays' => 1,
            ],
            '-1 day in seconds is 1 day' => [
                'valueInSeconds' => $oneDayInSeconds * -1,
                'expectedRoundedDays' => 1,
            ],
        ];
    }

    /**
     * @dataProvider getInDaysDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedInDays
     */
    public function testGetInDays($valueInSeconds, $expectedInDays)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedInDays, $this->readableDuration->getInDays());
    }

    /**
     * @return array
     */
    public function getInDaysDataProvider()
    {
        $oneDayInSeconds = 86400;

        return [
            'zero seconds is zero days' => [
                'valueInSeconds' => 0,
                'expectedInDays' => 0,
            ],
            '1 day in seconds is 1 day' => [
                'valueInSeconds' => $oneDayInSeconds,
                'expectedInDays' => 1,
            ],
            '-1 day in seconds is 1 day' => [
                'valueInSeconds' => $oneDayInSeconds * -1,
                'expectedInDays' => -1,
            ],
            '2 days in seconds is 2 days' => [
                'valueInSeconds' => ($oneDayInSeconds * 2),
                'expectedInDays' => 2,
            ],
            '-2 days in seconds is -2 days' => [
                'valueInSeconds' => $oneDayInSeconds * 2 * -1,
                'expectedInDays' => -2,
            ],
        ];
    }

    /**
     * @dataProvider getHoursDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedHours
     */
    public function testGetHours($valueInSeconds, $expectedHours)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedHours, $this->readableDuration->getHours());
    }

    /**
     * @return array
     */
    public function getHoursDataProvider()
    {
        $oneHourInSeconds = 3600;

        return [
            'zero seconds is zero hours' => [
                'valueInSeconds' => 0,
                'expectedHours' => 0,
            ],
            '1 hour in seconds is 1 hour' => [
                'valueInSeconds' => $oneHourInSeconds,
                'expectedHours' => 1,
            ],
            '-1 hour in seconds is 1 hour' => [
                'valueInSeconds' => $oneHourInSeconds * -1,
                'expectedHours' => 1,
            ],
            '2 hours in seconds is 2 hours' => [
                'valueInSeconds' => ($oneHourInSeconds * 2),
                'expectedHours' => 2,
            ],
            '-2 hours in seconds is -2 hours' => [
                'valueInSeconds' => $oneHourInSeconds * 2 * -1,
                'expectedHours' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getRoundedHoursDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedRoundedHours
     */
    public function testGetRoundedHours($valueInSeconds, $expectedRoundedHours)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedRoundedHours, $this->readableDuration->getRoundedHours());
    }

    /**
     * @return array
     */
    public function getRoundedHoursDataProvider()
    {
        $oneHourInSeconds = 3600;

        return [
            'zero seconds is zero hours' => [
                'valueInSeconds' => 0,
                'expectedRoundedHours' => 0,
            ],
            '0.8 hours in seconds is 1 hour' => [
                'valueInSeconds' => $oneHourInSeconds * 0.8,
                'expectedRoundedHours' => 1,
            ],
            '1 hour in seconds is 1 hour' => [
                'valueInSeconds' => $oneHourInSeconds,
                'expectedRoundedHours' => 1,
            ],
            '1.1 hour in seconds is 1 hour' => [
                'valueInSeconds' => $oneHourInSeconds * 1.1,
                'expectedRoundedHours' => 1,
            ],
            '-1 hour in seconds is 1 hour' => [
                'valueInSeconds' => $oneHourInSeconds * -1,
                'expectedRoundedHours' => 1,
            ],
        ];
    }

    /**
     * @dataProvider getInHoursDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedInHours
     */
    public function testGetInHours($valueInSeconds, $expectedInHours)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedInHours, $this->readableDuration->getInHours());
    }

    /**
     * @return array
     */
    public function getInHoursDataProvider()
    {
        $oneHourInSeconds = 3600;

        return [
            'zero seconds is zero hours' => [
                'valueInSeconds' => 0,
                'expectedInHours' => 0,
            ],
            '1 hour in seconds is 1 hour' => [
                'valueInSeconds' => $oneHourInSeconds,
                'expectedInHours' => 1,
            ],
            '-1 hour in seconds is 1 hour' => [
                'valueInSeconds' => $oneHourInSeconds * -1,
                'expectedInHours' => -1,
            ],
            '2 hours in seconds is 2 hours' => [
                'valueInSeconds' => ($oneHourInSeconds * 2),
                'expectedInHours' => 2,
            ],
            '-2 hours in seconds is -2 hours' => [
                'valueInSeconds' => $oneHourInSeconds * 2 * -1,
                'expectedInHours' => -2,
            ],
        ];
    }

    /**
     * @dataProvider getMinutesDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedMinutes
     */
    public function testGetMinutes($valueInSeconds, $expectedMinutes)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedMinutes, $this->readableDuration->getMinutes());
    }

    /**
     * @return array
     */
    public function getMinutesDataProvider()
    {
        $oneMinuteInSeconds = 60;

        return [
            'zero seconds is zero minutes' => [
                'valueInSeconds' => 0,
                'expectedMinutes' => 0,
            ],
            '1 minute in seconds is 1 minute' => [
                'valueInSeconds' => $oneMinuteInSeconds,
                'expectedMinutes' => 1,
            ],
            '-1 minute in seconds is 1 minute' => [
                'valueInSeconds' => $oneMinuteInSeconds * -1,
                'expectedMinutes' => 1,
            ],
            '2 minutes in seconds is 2 minutes' => [
                'valueInSeconds' => ($oneMinuteInSeconds * 2),
                'expectedMinutes' => 2,
            ],
            '-2 minutes in seconds is -2 minutes' => [
                'valueInSeconds' => $oneMinuteInSeconds * 2 * -1,
                'expectedMinutes' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getRoundedMinutesDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedRoundedMinutes
     */
    public function testGetRoundedMinutes($valueInSeconds, $expectedRoundedMinutes)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedRoundedMinutes, $this->readableDuration->getRoundedMinutes());
    }

    /**
     * @return array
     */
    public function getRoundedMinutesDataProvider()
    {
        $oneMinuteInSeconds = 60;

        return [
            'zero seconds is zero minutes' => [
                'valueInSeconds' => 0,
                'expectedRoundedMinutes' => 0,
            ],
            '0.8 minutes in seconds is 1 minute' => [
                'valueInSeconds' => $oneMinuteInSeconds * 0.8,
                'expectedRoundedMinutes' => 1,
            ],
            '1 minute in seconds is 1 minute' => [
                'valueInSeconds' => $oneMinuteInSeconds,
                'expectedRoundedMinutes' => 1,
            ],
            '1.1 minute in seconds is 1 minute' => [
                'valueInSeconds' => $oneMinuteInSeconds * 1.1,
                'expectedRoundedMinutes' => 1,
            ],
            '-1 minute in seconds is 1 minute' => [
                'valueInSeconds' => $oneMinuteInSeconds * -1,
                'expectedRoundedMinutes' => 1,
            ],
        ];
    }

    /**
     * @dataProvider getInMinutesDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedInMinutes
     */
    public function testGetInMinutes($valueInSeconds, $expectedInMinutes)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedInMinutes, $this->readableDuration->getInMinutes());
    }

    /**
     * @return array
     */
    public function getInMinutesDataProvider()
    {
        $oneMinuteInSeconds = 60;

        return [
            'zero seconds is zero minutes' => [
                'valueInSeconds' => 0,
                'expectedInMinutes' => 0,
            ],
            '1 minute in seconds is 1 minute' => [
                'valueInSeconds' => $oneMinuteInSeconds,
                'expectedInMinutes' => 1,
            ],
            '-1 minute in seconds is 1 minute' => [
                'valueInSeconds' => $oneMinuteInSeconds * -1,
                'expectedInMinutes' => -1,
            ],
            '2 minutes in seconds is 2 minutes' => [
                'valueInSeconds' => ($oneMinuteInSeconds * 2),
                'expectedInMinutes' => 2,
            ],
            '-2 minutes in seconds is -2 minutes' => [
                'valueInSeconds' => $oneMinuteInSeconds * 2 * -1,
                'expectedInMinutes' => -2,
            ],
        ];
    }

    /**
     * @dataProvider getSecondsDataProvider
     *
     * @param int $valueInSeconds
     * @param float $expectedSeconds
     */
    public function testGetSeconds($valueInSeconds, $expectedSeconds)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedSeconds, $this->readableDuration->getSeconds());
    }

    /**
     * @return array
     */
    public function getSecondsDataProvider()
    {
        return [
            'zero seconds is zero seconds' => [
                'valueInSeconds' => 0,
                'expectedSeconds' => 0,
            ],
            '1 second in seconds is 1 second' => [
                'valueInSeconds' => 1,
                'expectedSeconds' => 1,
            ],
            '-1 second in seconds is 1 second' => [
                'valueInSeconds' => -1,
                'expectedSeconds' => 1,
            ],
            '2 seconds in seconds is 2 seconds' => [
                'valueInSeconds' => 2,
                'expectedSeconds' => 2,
            ],
            '-2 seconds in seconds is -2 seconds' => [
                'valueInSeconds' => -2,
                'expectedSeconds' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getInMostAppropriateUnitsDataProvider
     *
     * @param int $valueInSeconds
     * @param int $precision
     * @param array $expectedUnits
     */
    public function testGetInMostAppropriateUnits($valueInSeconds, $precision, array $expectedUnits)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedUnits, $this->readableDuration->getInMostAppropriateUnits($precision));
//        var_dump($expectedUnits, $this->readableDuration->getInMostAppropriateUnits($precision));
//        exit();
    }

    /**
     * @return array
     */
    public function getInMostAppropriateUnitsDataProvider()
    {
        return [
            'zero, precision={non-scalar}' => [
                'valueInSeconds' => 0,
                'precision' => [],
                'expectedUnits' => []
            ],
            'zero, precision=1' => [
                'valueInSeconds' => 0,
                'precision' => 1,
                'expectedUnits' => []
            ],
            'zero, precision=7 (really should not do this)' => [
                'valueInSeconds' => 0,
                'precision' => 7,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_SECOND,
                        'value' => 0,
                    ],
                    [
                        'unit' => ReadableDuration::UNIT_SECOND,
                        'value' => 0,
                    ],
                    [
                        'unit' => ReadableDuration::UNIT_SECOND,
                        'value' => 0,
                    ],
                    [
                        'unit' => ReadableDuration::UNIT_SECOND,
                        'value' => 0,
                    ],
                    [
                        'unit' => ReadableDuration::UNIT_SECOND,
                        'value' => 0,
                    ],
                ]
            ],
            'one second, precision=1' => [
                'valueInSeconds' => 1,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_SECOND,
                        'value' => 1,
                    ],
                ]
            ],
            'one second, precision=2' => [
                'valueInSeconds' => 1,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_SECOND,
                        'value' => 1,
                    ],
                ]
            ],
            'one minute, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_MINUTE,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MINUTE,
                        'value' => 1,
                    ],
                ]
            ],
            'one minute, precision=2' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_MINUTE,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MINUTE,
                        'value' => 1,
                    ],
                ]
            ],
            '~one hour, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_HOUR - 1,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_HOUR,
                        'value' => 1,
                    ],
                ]
            ],
            'one hour, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_HOUR,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_HOUR,
                        'value' => 1,
                    ],
                ]
            ],
            'one yearish, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_YEAR,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            'one hour, precision=2' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_HOUR,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_HOUR,
                        'value' => 1,
                    ],
                ]
            ],
            '~one month, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_DAY * ReadableDuration::DAYS_PER_MONTH,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 1,
                    ],
                ]
            ],
            'one month, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_DAY * ReadableDuration::DAYS_PER_MONTH,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 1,
                    ],
                ]
            ],
            'one month, precision=2' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_DAY * ReadableDuration::DAYS_PER_MONTH,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 1,
                    ],
                ]
            ],
            '~nearly six months, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_DAY * ReadableDuration::DAYS_PER_MONTH * 6,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 6,
                    ],
                ]
            ],
            '~nearly six months, precision=2' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_DAY * ReadableDuration::DAYS_PER_MONTH * 6,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 5,
                    ],
                    [
                        'unit' => ReadableDuration::UNIT_DAY,
                        'value' => 27,
                    ],
                ]
            ],
            ' six months, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_DAY * ReadableDuration::DAYS_PER_MONTH * 6,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 6,
                    ],
                ]
            ],
            '~nearly one year, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_YEAR - 1,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            '~nearly one year, precision=2' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_YEAR - 1,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 11,
                    ],
                    [
                        'unit' => ReadableDuration::UNIT_DAY,
                        'value' => 30,
                    ],
                ]
            ],
            '~one year, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_YEAR,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            '~one year, precision=2' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_YEAR,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 11,
                    ],
                    [
                        'unit' => ReadableDuration::UNIT_DAY,
                        'value' => 30,
                    ],
                ]
            ],
            '~one and a half years, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_YEAR * 1.5,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            '~one and a half years, precision=2' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_YEAR * 1.5,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 1,
                    ],
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 6,
                    ],
                ]
            ],
            '~3.4 years, precision=1' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_YEAR * 3.4,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 3,
                    ],
                ]
            ],
            '~3.4 years, precision=2' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_YEAR * 3.4,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 3,
                    ],
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 5,
                    ],
                ]
            ],
            '~3.4 years, precision=3' => [
                'valueInSeconds' => ReadableDuration::SECONDS_PER_YEAR * 3.4,
                'precision' => 3,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 3,
                    ],
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 4,
                    ],
                    [
                        'unit' => ReadableDuration::UNIT_DAY,
                        'value' => 23,
                    ],
                ]
            ],
        ];
    }
}
