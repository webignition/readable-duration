<?php

namespace webignition\Tests\ReadableDuration;

use webignition\ReadableDuration\Factory;

class DemoTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Factory
     */
    private $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new Factory();
    }

    /**
     * 100000 seconds is 1 day, 3 hours, 46 minutes and 40 seconds
     */
    public function testGetNumberOfYearsMonthsDaysHoursHoursMinutesSeconds()
    {
        $readableDuration = $this->factory->create(100000);

        $this->assertEquals(1, $readableDuration->getDays());
        $this->assertEquals(3, $readableDuration->getHours());
        $this->assertEquals(46, $readableDuration->getMinutes());
        $this->assertEquals(40, $readableDuration->getSeconds());
    }

    /**
     * 100000 seconds as years, months, days, hours, minute or seconds
     *
     * Note: these are human-readable convenience representations not exact
     *
     * 100000 seconds is strictly 1.16 days. As far as convenience is concerned, that's 1 day.
     * 100000 seconds is strictly 27.78 hours. As far as convenience is concerned, that's 28 hours.
     */
    public function testGetInYearsMonthsDaysHoursMinutesOrSeconds()
    {
        $readableDuration = $this->factory->create(100000);

        $this->assertEquals(0, $readableDuration->getInYears());
        $this->assertEquals(0, $readableDuration->getInMonths());
        $this->assertEquals(1, $readableDuration->getInDays());
        $this->assertEquals(28, $readableDuration->getInHours());
        $this->assertEquals(1667, $readableDuration->getInMinutes());
        $this->assertEquals(100000, $readableDuration->getInSeconds());
    }

    /**
     * 100000 seconds:
     *
     * - represented as a single time unit is 1 day
     * - represented as two time units is 1 day 4 hours
     * - represented as three time units is 1 day 3 hours 47 minutes
     *
     */
    public function testGetAsTheMostAppropriateHumanValue()
    {
        $readableDuration = $this->factory->create(100000);

        /**
         * 100000 seconds, as a single time unit is 1 day
         */
        $this->assertEquals(
            [
                [
                    'unit' => 'day',
                    'value' => 1
                ]
            ],
            $this->factory->getInMostAppropriateUnits($readableDuration)
        );


        /**
         * 100000 seconds, as two time units is 1 day 4 hours
         */
        $this->assertEquals(
            [
                [
                    'unit' => 'day',
                    'value' => 1
                ],
                [
                    'unit' => 'hour',
                    'value' => 4
                ]
            ],
            $this->factory->getInMostAppropriateUnits($readableDuration, 2)
        );


        /**
         * 100000 seconds, as three time units is 1 day 3 hours 47 minutes
         */
        $this->assertEquals(
            [
                [
                    'unit' => 'day',
                    'value' => 1
                ],
                [
                    'unit' => 'hour',
                    'value' => 3
                ],
                [
                    'unit' => 'minute',
                    'value' => 47
                ]
            ],
            $this->factory->getInMostAppropriateUnits($readableDuration, 3)
        );
    }
}
