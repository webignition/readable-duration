<?php
/** @noinspection PhpDocSignatureInspection */

namespace webignition\ReadableDuration\Tests;

use webignition\ReadableDuration\Durations;
use webignition\ReadableDuration\Factory;
use webignition\ReadableDuration\ReadableDuration;

class ReadableDurationTest extends \PHPUnit\Framework\TestCase
{
    public function testIsPast()
    {
        $this->assertTrue($this->create(-1)->isPast());
        $this->assertFalse($this->create(0)->isPast());
        $this->assertFalse($this->create(1)->isPast());
    }

    public function testIsPresent()
    {
        $this->assertFalse($this->create(-1)->isPresent());
        $this->assertTrue($this->create(0)->isPresent());
        $this->assertFalse($this->create(1)->isPresent());
    }

    public function testIsFuture()
    {
        $this->assertFalse($this->create(-1)->isFuture());
        $this->assertFalse($this->create(0)->isFuture());
        $this->assertTrue($this->create(1)->isFuture());
    }

    /**
     * @dataProvider getYearsDataProvider
     */
    public function testGetYears(int $valueInSeconds, int $expectedYears)
    {
        $this->assertEquals($expectedYears, $this->create($valueInSeconds)->getYears());
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
            '1 hour is zero years' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedYears' => 0,
            ],
            '-1 hour is zero years' => [
                'valueInSeconds' => -Durations::SECONDS_PER_HOUR,
                'expectedYears' => 0,
            ],
            '~1 year is one year' => [
                'valueInSeconds' => $aboutOneYearInSeconds,
                'expectedYears' => 1,
            ],
            '~ -1 year is one year' => [
                'valueInSeconds' => ($aboutOneYearInSeconds * -1),
                'expectedYears' => 1,
            ],
            '~2 years is two years' => [
                'valueInSeconds' => $aboutTwoYearsInSeconds,
                'expectedYears' => 2,
            ],
            '~ -2 two years is two years' => [
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
        $this->assertEquals($expectedRoundedYears, $this->create($valueInSeconds)->getRoundedYears());
    }

    public function getRoundedYearsDataProvider(): array
    {
        $aboutOneYearInSeconds = Durations::SECONDS_PER_YEAR + Durations::SECONDS_PER_DAY;
        $sixMonthsInSeconds = $aboutOneYearInSeconds / 2;

        return [
            'zero seconds is zero years' => [
                'valueInSeconds' => 0,
                'expectedRoundedYears' => 0,
            ],
            '1 hour is zero years' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedRoundedYears' => 0,
            ],
            '-1 hour is zero years' => [
                'valueInSeconds' => -Durations::SECONDS_PER_HOUR,
                'expectedRoundedYears' => 0,
            ],
            '6 months is zero years' => [
                'valueInSeconds' => $sixMonthsInSeconds,
                'expectedRoundedYears' => 0,
            ],
            '9 months is one year' => [
                'valueInSeconds' => (int) ($sixMonthsInSeconds * 1.5),
                'expectedRoundedYears' => 1,
            ],
            '-6 months is zero years' => [
                'valueInSeconds' => $sixMonthsInSeconds * -1,
                'expectedRoundedYears' => 0,
            ],
            '-9 months in seconds is one year' => [
                'valueInSeconds' => (int) ($sixMonthsInSeconds * 1.5 * -1),
                'expectedRoundedYears' => 1,
            ],
            '1 year is one year' => [
                'valueInSeconds' => $aboutOneYearInSeconds,
                'expectedRoundedYears' => 1,
            ],
            '2 years is two years' => [
                'valueInSeconds' => $aboutOneYearInSeconds * 2,
                'expectedRoundedYears' => 2,
            ],
        ];
    }

    /**
     * @dataProvider getInYearsDataProvider
     */
    public function testGetInYears(int $valueInSeconds, int $expectedYears)
    {
        $this->assertEquals($expectedYears, $this->create($valueInSeconds)->getInYears());
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
            '1 hour is zero years' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedYears' => 0,
            ],
            '-1 hour is zero years' => [
                'valueInSeconds' => -Durations::SECONDS_PER_HOUR,
                'expectedYears' => 0,
            ],
            '6 months is one year' => [
                'valueInSeconds' => $sixMonthsInSeconds,
                'expectedYears' => 1
            ],
            '9 months is one year' => [
                'valueInSeconds' => (int) ($sixMonthsInSeconds * 1.5),
                'expectedYears' => 1,
            ],
            '-6 months is -1 years' => [
                'valueInSeconds' => $sixMonthsInSeconds * -1,
                'expectedYears' => -1,
            ],
            '-more 9 months is -1 year' => [
                'valueInSeconds' => (($sixMonthsInSeconds + ($sixMonthsInSeconds / 2)) * -1),
                'expectedYears' => -1,
            ],
            '1 year is one year' => [
                'valueInSeconds' => $aboutOneYearInSeconds,
                'expectedYears' => 1,
            ],
            '2 years is two years' => [
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
        $this->assertEquals($expectedMonths, $this->create($valueInSeconds)->getMonths());
    }

    public function getMonthsDataProvider(): array
    {
        $aboutOneMonthInSeconds = Durations::SECONDS_PER_MONTH + Durations::SECONDS_PER_DAY;

        return [
            'zero seconds is zero months' => [
                'valueInSeconds' => 0,
                'expectedMonths' => 0,
            ],
            '1 month is 1 month' => [
                'valueInSeconds' => $aboutOneMonthInSeconds,
                'expectedMonths' => 1,
            ],
            '-1 month is 1 month' => [
                'valueInSeconds' => $aboutOneMonthInSeconds * -1,
                'expectedMonths' => 1,
            ],
            '2 months is 2 months' => [
                'valueInSeconds' => $aboutOneMonthInSeconds * 2,
                'expectedMonths' => 2,
            ],
            '-2 months is -2 months' => [
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
        $this->assertEquals($expectedRoundedMonths, $this->create($valueInSeconds)->getRoundedMonths());
    }

    public function getRoundedMonthsDataProvider(): array
    {
        return [
            'zero seconds is zero roundedMonths' => [
                'valueInSeconds' => 0,
                'expectedRoundedMonths' => 0,
            ],
            '0.8 months is 1 month' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_MONTH * 0.8),
                'expectedRoundedMonths' => 1,
            ],
            '1 month is 1 month' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH,
                'expectedRoundedMonths' => 1,
            ],
            '1.1 months is 1 month' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_MONTH * 1.1),
                'expectedRoundedMonths' => 1,
            ],
            '-1 month is 1 month' => [
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
        $this->assertEquals($expectedInMonths, $this->create($valueInSeconds)->getInMonths());
    }

    public function getInMonthsDataProvider(): array
    {
        return [
            'zero seconds is zero inMonths' => [
                'valueInSeconds' => 0,
                'expectedInMonths' => 0,
            ],
            '1 month is 1 month' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH,
                'expectedInMonths' => 1,
            ],
            '-1 month is 1 month' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH * -1,
                'expectedInMonths' => -1,
            ],
            '2 months is 2 months' => [
                'valueInSeconds' => (Durations::SECONDS_PER_MONTH * 2),
                'expectedInMonths' => 2,
            ],
            '-2 months is 2 months' => [
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
        $this->assertEquals($expectedDays, $this->create($valueInSeconds)->getDays());
    }

    public function getDaysDataProvider(): array
    {
        return [
            'zero seconds is zero days' => [
                'valueInSeconds' => 0,
                'expectedDays' => 0,
            ],
            '1 day is 1 day' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY,
                'expectedDays' => 1,
            ],
            '-1 day is 1 day' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY * -1,
                'expectedDays' => 1,
            ],
            '2 days is 2 days' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY * 2,
                'expectedDays' => 2,
            ],
            '-2 days is -2 days' => [
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
        $this->assertEquals($expectedRoundedDays, $this->create($valueInSeconds)->getRoundedDays());
    }

    public function getRoundedDaysDataProvider(): array
    {
        return [
            'zero seconds is zero days' => [
                'valueInSeconds' => 0,
                'expectedRoundedDays' => 0,
            ],
            '0.8 days is 1 day' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_DAY * 0.8),
                'expectedRoundedDays' => 1,
            ],
            '1 day is 1 day' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY,
                'expectedRoundedDays' => 1,
            ],
            '1.1 days is 1 day' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_DAY * 1.1),
                'expectedRoundedDays' => 1,
            ],
            '-1 day is 1 day' => [
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
        $this->assertEquals($expectedInDays, $this->create($valueInSeconds)->getInDays());
    }

    public function getInDaysDataProvider(): array
    {
        return [
            'zero seconds is zero days' => [
                'valueInSeconds' => 0,
                'expectedInDays' => 0,
            ],
            '1 day is 1 day' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY,
                'expectedInDays' => 1,
            ],
            '-1 day is 1 day' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY * -1,
                'expectedInDays' => -1,
            ],
            '2 days is 2 days' => [
                'valueInSeconds' => Durations::SECONDS_PER_DAY * 2,
                'expectedInDays' => 2,
            ],
            '-2 days is -2 days' => [
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
        $this->assertEquals($expectedHours, $this->create($valueInSeconds)->getHours());
    }

    public function getHoursDataProvider(): array
    {
        return [
            'zero seconds is zero hours' => [
                'valueInSeconds' => 0,
                'expectedHours' => 0,
            ],
            '1 hours is 1 hour' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedHours' => 1,
            ],
            '-1 hour is 1 hour' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR * -1,
                'expectedHours' => 1,
            ],
            '2 hours is 2 hours' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR * 2,
                'expectedHours' => 2,
            ],
            '-2 hours is -2 hours' => [
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
        $this->assertEquals($expectedRoundedHours, $this->create($valueInSeconds)->getRoundedHours());
    }

    public function getRoundedHoursDataProvider(): array
    {
        return [
            'zero seconds is zero hours' => [
                'valueInSeconds' => 0,
                'expectedRoundedHours' => 0,
            ],
            '0.8 hours is 1 hour' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_HOUR * 0.8),
                'expectedRoundedHours' => 1,
            ],
            '1 hour  is 1 hour' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedRoundedHours' => 1,
            ],
            '1.1 hours is 1 hour' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_HOUR * 1.1),
                'expectedRoundedHours' => 1,
            ],
            '-1 hour is 1 hour' => [
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
        $this->assertEquals($expectedInHours, $this->create($valueInSeconds)->getInHours());
    }

    public function getInHoursDataProvider(): array
    {
        return [
            'zero seconds is zero hours' => [
                'valueInSeconds' => 0,
                'expectedInHours' => 0,
            ],
            '1 hour is 1 hour' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'expectedInHours' => 1,
            ],
            '-1 hour is 1 hour' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR * -1,
                'expectedInHours' => -1,
            ],
            '2 hours is 2 hours' => [
                'valueInSeconds' => (Durations::SECONDS_PER_HOUR * 2),
                'expectedInHours' => 2,
            ],
            '-2 hours is -2 hours' => [
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
        $this->assertEquals($expectedMinutes, $this->create($valueInSeconds)->getMinutes());
    }

    public function getMinutesDataProvider(): array
    {
        return [
            'zero seconds is zero minutes' => [
                'valueInSeconds' => 0,
                'expectedMinutes' => 0,
            ],
            '1 minute is 1 minute' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE,
                'expectedMinutes' => 1,
            ],
            '-1 minute is 1 minute' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE * -1,
                'expectedMinutes' => 1,
            ],
            '2 minutes is 2 minutes' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE * 2,
                'expectedMinutes' => 2,
            ],
            '-2 minutes is -2 minutes' => [
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
        $this->assertEquals($expectedRoundedMinutes, $this->create($valueInSeconds)->getRoundedMinutes());
    }

    public function getRoundedMinutesDataProvider(): array
    {
        return [
            'zero seconds is zero minutes' => [
                'valueInSeconds' => 0,
                'expectedRoundedMinutes' => 0,
            ],
            '0.8 minutes is 1 minute' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_MINUTE * 0.8),
                'expectedRoundedMinutes' => 1,
            ],
            '1 minute is 1 minute' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE,
                'expectedRoundedMinutes' => 1,
            ],
            '1.1 minutes is 1 minute' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_MINUTE * 1.1),
                'expectedRoundedMinutes' => 1,
            ],
            '-1 minute is 1 minute' => [
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
        $this->assertEquals($expectedInMinutes, $this->create($valueInSeconds)->getInMinutes());
    }

    public function getInMinutesDataProvider(): array
    {
        return [
            'zero seconds is zero minutes' => [
                'valueInSeconds' => 0,
                'expectedInMinutes' => 0,
            ],
            '1 minute is 1 minute' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE,
                'expectedInMinutes' => 1,
            ],
            '-1 minute is 1 minute' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE * -1,
                'expectedInMinutes' => -1,
            ],
            '2 minutes is 2 minutes' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE * 2,
                'expectedInMinutes' => 2,
            ],
            '-2 minutes is -2 minutes' => [
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
        $this->assertEquals($expectedSeconds, $this->create($valueInSeconds)->getSeconds());
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

    private function create(int $valueInSeconds): ReadableDuration
    {
        $factory = new Factory();

        return $factory->create($valueInSeconds);
    }
}
