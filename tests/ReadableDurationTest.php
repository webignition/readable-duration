<?php
/** @noinspection PhpDocSignatureInspection */

namespace webignition\Tests\ReadableDuration;

use webignition\ReadableDuration\Durations;
use webignition\ReadableDuration\ReadableDuration;

class ReadableDurationTest extends AbstractReadableDurationTest
{
    /**
     * @dataProvider setValueInSecondsGetInSecondsDataProvider
     */
    public function testSetValueInSecondsGetInSeconds(int $valueInSeconds, int $expectedSeconds)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedSeconds, $this->readableDuration->getInSeconds());
    }

    public function setValueInSecondsGetInSecondsDataProvider(): array
    {
        return [
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
     * @dataProvider isPastIsPresntIsFutureDataProvider
     */
    public function testIsPastIsPresentIsFuture(
        int $valueInSeconds,
        bool $expectedIsPast,
        bool $expectedIsPresent,
        bool $expectedIsFuture
    ) {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedIsPast, $this->readableDuration->isPast());
        $this->assertEquals($expectedIsPresent, $this->readableDuration->isPresent());
        $this->assertEquals($expectedIsFuture, $this->readableDuration->isFuture());
    }

    public function isPastIsPresntIsFutureDataProvider(): array
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
     */
    public function testGetYears(int $valueInSeconds, int $expectedYears)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedYears, $this->readableDuration->getYears());
    }

    public function getYearsDataProvider(): array
    {
        $aboutOneYearInSeconds = Durations::SECONDS_PER_YEAR + Durations::SECONDS_PER_DAY;
        $aboutTwoYearsInSeconds = $aboutOneYearInSeconds * 2;

        return [
            'zero seconds is zero years' => [
                'valueInSeconds' => 0,
                'expectedYears' => 0,
            ],
            'one hour is zero years' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedYears' => 0,
            ],
            '-one hour is zero years' => [
                'valueInSeconds' => -Durations::SECONDS_PER_HOUR,
                'expectedYears' => 0,
            ],
            '~1 year in seconds is one year' => [
                'valueInSeconds' =>$aboutOneYearInSeconds,
                'expectedYears' => 1,
            ],
            '~-1 year in seconds is one year' => [
                'valueInSeconds' => ($aboutOneYearInSeconds * -1),
                'expectedYears' => 1,
            ],
            '~2 years in seconds is two years' => [
                'valueInSeconds' => $aboutTwoYearsInSeconds,
                'expectedYears' => 2,
            ],
            '~-2 years in seconds is two years' => [
                'valueInSeconds' => ($aboutTwoYearsInSeconds * -1),
                'expectedYears' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getRoundedYearsDataProvider
     */
    public function testGetRoundedYears(int $valueInSeconds, int $expectedRoundedYears)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedRoundedYears, $this->readableDuration->getRoundedYears());
    }

    public function getRoundedYearsDataProvider(): array
    {
        $aboutOneYearInSeconds = Durations::SECONDS_PER_YEAR + Durations::SECONDS_PER_DAY;
        $sixMonthsInSeconds = $aboutOneYearInSeconds / 2;
        $twoYearsInSeconds = $aboutOneYearInSeconds * 2;

        return [
            'zero seconds is zero years' => [
                'valueInSeconds' => 0,
                'expectedRoundedYears' => 0,
            ],
            '3600 seconds is zero years' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedRoundedYears' => 0,
            ],
            '-3600 seconds is zero years' => [
                'valueInSeconds' => -Durations::SECONDS_PER_HOUR,
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
                'valueInSeconds' => $aboutOneYearInSeconds,
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
     */
    public function testGetInYears(int $valueInSeconds, int $expectedYears)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedYears, $this->readableDuration->getInYears());
    }

    public function getInYearsDataProvider(): array
    {
        $aboutOneYearInSeconds = Durations::SECONDS_PER_YEAR + Durations::SECONDS_PER_DAY;
        $sixMonthsInSeconds = $aboutOneYearInSeconds / 2;
        $twoYearsInSeconds = $aboutOneYearInSeconds * 2;

        return [
            'zero seconds is zero years' => [
                'valueInSeconds' => 0,
                'expectedYears' => 0,
            ],
            'one hour is zero years' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedYears' => 0,
            ],
            '-one hour is zero years' => [
                'valueInSeconds' => -Durations::SECONDS_PER_HOUR,
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
                'valueInSeconds' => $aboutOneYearInSeconds,
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
     */
    public function testGetMonths(int $valueInSeconds, int $expectedMonths)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedMonths, $this->readableDuration->getMonths());
    }

    public function getMonthsDataProvider(): array
    {
        $aboutOneMonthInSeconds = Durations::SECONDS_PER_MONTH + Durations::SECONDS_PER_DAY;

        return [
            'zero seconds is zero months' => [
                'valueInSeconds' => 0,
                'expectedMonths' => 0,
            ],
            '1 month in seconds is 1 month' => [
                'valueInSeconds' => $aboutOneMonthInSeconds,
                'expectedMonths' => 1,
            ],
            '-1 month in seconds is 1 month' => [
                'valueInSeconds' => $aboutOneMonthInSeconds * -1,
                'expectedMonths' => 1,
            ],
            '2 months in seconds is 2 months' => [
                'valueInSeconds' => $aboutOneMonthInSeconds * 2,
                'expectedMonths' => 2,
            ],
            '-2 months in seconds is -2 months' => [
                'valueInSeconds' => $aboutOneMonthInSeconds * 2 * -1,
                'expectedMonths' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getRoundedMonthsDataProvider
     */
    public function testGetRoundedMonths(int $valueInSeconds, int $expectedRoundedMonths)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedRoundedMonths, $this->readableDuration->getRoundedMonths());
    }

    public function getRoundedMonthsDataProvider(): array
    {
        return [
            'zero seconds is zero roundedMonths' => [
                'valueInSeconds' => 0,
                'expectedRoundedMonths' => 0,
            ],
            '0.8 month in seconds is 1 month' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_MONTH * 0.8),
                'expectedRoundedMonths' => 1,
            ],
            '1 month in seconds is 1 month' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH,
                'expectedRoundedMonths' => 1,
            ],
            '1.1 month in seconds is 1 month' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_MONTH * 1.1),
                'expectedRoundedMonths' => 1,
            ],
            '-1 month in seconds is 1 month' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH * -1,
                'expectedRoundedMonths' => 1,
            ],
        ];
    }

    /**
     * @dataProvider getInMonthsDataProvider
     */
    public function testGetInMonths(int $valueInSeconds, int $expectedInMonths)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedInMonths, $this->readableDuration->getInMonths());
    }

    public function getInMonthsDataProvider(): array
    {
        return [
            'zero seconds is zero inMonths' => [
                'valueInSeconds' => 0,
                'expectedInMonths' => 0,
            ],
            '1 month in seconds is 1 month' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH,
                'expectedInMonths' => 1,
            ],
            '-1 month in seconds is 1 month' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH * -1,
                'expectedInMonths' => -1,
            ],
            '2 inMonths in seconds is 2 months' => [
                'valueInSeconds' => (Durations::SECONDS_PER_MONTH * 2),
                'expectedInMonths' => 2,
            ],
            '-2 inMonths in seconds is 2 months' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH * 2 * -1,
                'expectedInMonths' => -2,
            ],
        ];
    }

    /**
     * @dataProvider getDaysDataProvider
     */
    public function testGetDays(int $valueInSeconds, int $expectedDays)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedDays, $this->readableDuration->getDays());
    }

    public function getDaysDataProvider(): array
    {
        return [
            'zero seconds is zero days' => [
                'valueInSeconds' => 0,
                'expectedDays' => 0,
            ],
            '1 day in seconds is 1 day' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY,
                'expectedDays' => 1,
            ],
            '-1 day in seconds is 1 day' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY * -1,
                'expectedDays' => 1,
            ],
            '2 days in seconds is 2 days' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY * 2,
                'expectedDays' => 2,
            ],
            '-2 days in seconds is -2 days' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY * 2 * -1,
                'expectedDays' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getRoundedDaysDataProvider
     */
    public function testGetRoundedDays(int $valueInSeconds, int $expectedRoundedDays)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedRoundedDays, $this->readableDuration->getRoundedDays());
    }

    public function getRoundedDaysDataProvider(): array
    {
        return [
            'zero seconds is zero days' => [
                'valueInSeconds' => 0,
                'expectedRoundedDays' => 0,
            ],
            '0.8 days in seconds is 1 day' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_DAY * 0.8),
                'expectedRoundedDays' => 1,
            ],
            '1 day in seconds is 1 day' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY,
                'expectedRoundedDays' => 1,
            ],
            '1.1 day in seconds is 1 day' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_DAY * 1.1),
                'expectedRoundedDays' => 1,
            ],
            '-1 day in seconds is 1 day' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY * -1,
                'expectedRoundedDays' => 1,
            ],
        ];
    }

    /**
     * @dataProvider getInDaysDataProvider
     */
    public function testGetInDays(int $valueInSeconds, int $expectedInDays)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedInDays, $this->readableDuration->getInDays());
    }

    public function getInDaysDataProvider(): array
    {
        return [
            'zero seconds is zero days' => [
                'valueInSeconds' => 0,
                'expectedInDays' => 0,
            ],
            '1 day in seconds is 1 day' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY,
                'expectedInDays' => 1,
            ],
            '-1 day in seconds is 1 day' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY * -1,
                'expectedInDays' => -1,
            ],
            '2 days in seconds is 2 days' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY * 2,
                'expectedInDays' => 2,
            ],
            '-2 days in seconds is -2 days' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY * 2 * -1,
                'expectedInDays' => -2,
            ],
        ];
    }

    /**
     * @dataProvider getHoursDataProvider
     */
    public function testGetHours(int $valueInSeconds, int $expectedHours)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedHours, $this->readableDuration->getHours());
    }

    public function getHoursDataProvider(): array
    {
        return [
            'zero seconds is zero hours' => [
                'valueInSeconds' => 0,
                'expectedHours' => 0,
            ],
            '1 hour in seconds is 1 hour' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedHours' => 1,
            ],
            '-1 hour in seconds is 1 hour' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR * -1,
                'expectedHours' => 1,
            ],
            '2 hours in seconds is 2 hours' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR * 2,
                'expectedHours' => 2,
            ],
            '-2 hours in seconds is -2 hours' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR * 2 * -1,
                'expectedHours' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getRoundedHoursDataProvider
     */
    public function testGetRoundedHours(int $valueInSeconds, int $expectedRoundedHours)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedRoundedHours, $this->readableDuration->getRoundedHours());
    }

    public function getRoundedHoursDataProvider(): array
    {
        return [
            'zero seconds is zero hours' => [
                'valueInSeconds' => 0,
                'expectedRoundedHours' => 0,
            ],
            '0.8 hours in seconds is 1 hour' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_HOUR * 0.8),
                'expectedRoundedHours' => 1,
            ],
            '1 hour in seconds is 1 hour' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedRoundedHours' => 1,
            ],
            '1.1 hour in seconds is 1 hour' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_HOUR * 1.1),
                'expectedRoundedHours' => 1,
            ],
            '-1 hour in seconds is 1 hour' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR * -1,
                'expectedRoundedHours' => 1,
            ],
        ];
    }

    /**
     * @dataProvider getInHoursDataProvider
     */
    public function testGetInHours(int $valueInSeconds, int $expectedInHours)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedInHours, $this->readableDuration->getInHours());
    }

    public function getInHoursDataProvider(): array
    {
        return [
            'zero seconds is zero hours' => [
                'valueInSeconds' => 0,
                'expectedInHours' => 0,
            ],
            '1 hour in seconds is 1 hour' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedInHours' => 1,
            ],
            '-1 hour in seconds is 1 hour' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR * -1,
                'expectedInHours' => -1,
            ],
            '2 hours in seconds is 2 hours' => [
                'valueInSeconds' => (Durations::SECONDS_PER_HOUR * 2),
                'expectedInHours' => 2,
            ],
            '-2 hours in seconds is -2 hours' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR * 2 * -1,
                'expectedInHours' => -2,
            ],
        ];
    }

    /**
     * @dataProvider getMinutesDataProvider
     */
    public function testGetMinutes(int $valueInSeconds, int $expectedMinutes)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedMinutes, $this->readableDuration->getMinutes());
    }

    public function getMinutesDataProvider(): array
    {
        return [
            'zero seconds is zero minutes' => [
                'valueInSeconds' => 0,
                'expectedMinutes' => 0,
            ],
            '1 minute in seconds is 1 minute' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE,
                'expectedMinutes' => 1,
            ],
            '-1 minute in seconds is 1 minute' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE * -1,
                'expectedMinutes' => 1,
            ],
            '2 minutes in seconds is 2 minutes' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE * 2,
                'expectedMinutes' => 2,
            ],
            '-2 minutes in seconds is -2 minutes' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE * 2 * -1,
                'expectedMinutes' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getRoundedMinutesDataProvider
     */
    public function testGetRoundedMinutes(int $valueInSeconds, int $expectedRoundedMinutes)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedRoundedMinutes, $this->readableDuration->getRoundedMinutes());
    }

    public function getRoundedMinutesDataProvider(): array
    {
        return [
            'zero seconds is zero minutes' => [
                'valueInSeconds' => 0,
                'expectedRoundedMinutes' => 0,
            ],
            '0.8 minutes in seconds is 1 minute' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_MINUTE * 0.8),
                'expectedRoundedMinutes' => 1,
            ],
            '1 minute in seconds is 1 minute' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE,
                'expectedRoundedMinutes' => 1,
            ],
            '1.1 minute in seconds is 1 minute' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_MINUTE * 1.1),
                'expectedRoundedMinutes' => 1,
            ],
            '-1 minute in seconds is 1 minute' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE * -1,
                'expectedRoundedMinutes' => 1,
            ],
        ];
    }

    /**
     * @dataProvider getInMinutesDataProvider
     */
    public function testGetInMinutes(int $valueInSeconds, int $expectedInMinutes)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedInMinutes, $this->readableDuration->getInMinutes());
    }

    public function getInMinutesDataProvider(): array
    {
        return [
            'zero seconds is zero minutes' => [
                'valueInSeconds' => 0,
                'expectedInMinutes' => 0,
            ],
            '1 minute in seconds is 1 minute' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE,
                'expectedInMinutes' => 1,
            ],
            '-1 minute in seconds is 1 minute' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE * -1,
                'expectedInMinutes' => -1,
            ],
            '2 minutes in seconds is 2 minutes' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE * 2,
                'expectedInMinutes' => 2,
            ],
            '-2 minutes in seconds is -2 minutes' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE * 2 * -1,
                'expectedInMinutes' => -2,
            ],
        ];
    }

    /**
     * @dataProvider getSecondsDataProvider
     */
    public function testGetSeconds(int $valueInSeconds, int $expectedSeconds)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedSeconds, $this->readableDuration->getSeconds());
    }

    public function getSecondsDataProvider(): array
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
     */
    public function testGetInMostAppropriateUnits(int $valueInSeconds, int $precision, array $expectedUnits)
    {
        $this->readableDuration->setValueInSeconds($valueInSeconds);

        $this->assertEquals($expectedUnits, $this->readableDuration->getInMostAppropriateUnits($precision));
    }

    public function getInMostAppropriateUnitsDataProvider(): array
    {
        return [
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
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MINUTE,
                        'value' => 1,
                    ],
                ]
            ],
            'one minute, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MINUTE,
                        'value' => 1,
                    ],
                ]
            ],
            '~one hour, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR - 1,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_HOUR,
                        'value' => 1,
                    ],
                ]
            ],
            'one hour, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_HOUR,
                        'value' => 1,
                    ],
                ]
            ],
            'one yearish, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_YEAR,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            'one hour, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_HOUR,
                        'value' => 1,
                    ],
                ]
            ],
            '~one month, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 1,
                    ],
                ]
            ],
            'one month, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 1,
                    ],
                ]
            ],
            'one month, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 1,
                    ],
                ]
            ],
            '~nearly six months, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH * 6,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 6,
                    ],
                ]
            ],
            '~nearly six months, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH * 6,
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
                'valueInSeconds' => Durations::SECONDS_PER_MONTH * 6,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_MONTH,
                        'value' => 6,
                    ],
                ]
            ],
            '~nearly one year, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_YEAR - 1,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            '~nearly one year, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_YEAR - 1,
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
                'valueInSeconds' => Durations::SECONDS_PER_YEAR,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            '~one year, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_YEAR,
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
                'valueInSeconds' => (int) (Durations::SECONDS_PER_YEAR * 1.5),
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            '~one and a half years, precision=2' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_YEAR * 1.5),
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
                'valueInSeconds' => (int) (Durations::SECONDS_PER_YEAR * 3.4),
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => ReadableDuration::UNIT_YEAR,
                        'value' => 3,
                    ],
                ]
            ],
            '~3.4 years, precision=2' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_YEAR * 3.4),
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
                'valueInSeconds' => (int) (Durations::SECONDS_PER_YEAR * 3.4),
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
