<?php
/** @noinspection PhpDocSignatureInspection */

namespace webignition\Tests\ReadableDuration;

use webignition\ReadableDuration\Durations;
use webignition\ReadableDuration\Factory;
use webignition\ReadableDuration\ReadableDuration;
use webignition\ReadableDuration\Units;

class FactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $factory = new Factory();

        $readableDuration = $factory->create(0);

        $this->assertInstanceOf(ReadableDuration::class, $readableDuration);
    }

    /**
     * @dataProvider getInMostAppropriateUnitsDataProvider
     */
    public function testGetInMostAppropriateUnits(int $valueInSeconds, int $precision, array $expectedUnits)
    {
        $factory = new Factory();

        $readableDuration = $factory->create($valueInSeconds);

        $this->assertEquals($expectedUnits, $factory->getInMostAppropriateUnits($readableDuration, $precision));
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
                        'unit' => Units::UNIT_SECOND,
                        'value' => 0,
                    ],
                    [
                        'unit' => Units::UNIT_SECOND,
                        'value' => 0,
                    ],
                    [
                        'unit' => Units::UNIT_SECOND,
                        'value' => 0,
                    ],
                    [
                        'unit' => Units::UNIT_SECOND,
                        'value' => 0,
                    ],
                    [
                        'unit' => Units::UNIT_SECOND,
                        'value' => 0,
                    ],
                ]
            ],
            'one second, precision=1' => [
                'valueInSeconds' => 1,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_SECOND,
                        'value' => 1,
                    ],
                ]
            ],
            'one second, precision=2' => [
                'valueInSeconds' => 1,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_SECOND,
                        'value' => 1,
                    ],
                ]
            ],
            'one minute, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_MINUTE,
                        'value' => 1,
                    ],
                ]
            ],
            'one minute, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_MINUTE,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_MINUTE,
                        'value' => 1,
                    ],
                ]
            ],
            '~one hour, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR - 1,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_HOUR,
                        'value' => 1,
                    ],
                ]
            ],
            'one hour, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_HOUR,
                        'value' => 1,
                    ],
                ]
            ],
            'one yearish, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_YEAR,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            'one hour, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_HOUR,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_HOUR,
                        'value' => 1,
                    ],
                ]
            ],
            '~one month, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_MONTH,
                        'value' => 1,
                    ],
                ]
            ],
            'one month, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_MONTH,
                        'value' => 1,
                    ],
                ]
            ],
            'one month, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_MONTH,
                        'value' => 1,
                    ],
                ]
            ],
            '~nearly six months, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH * 6,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_MONTH,
                        'value' => 6,
                    ],
                ]
            ],
            '~nearly six months, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH * 6,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_MONTH,
                        'value' => 5,
                    ],
                    [
                        'unit' => Units::UNIT_DAY,
                        'value' => 27,
                    ],
                ]
            ],
            ' six months, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_MONTH * 6,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_MONTH,
                        'value' => 6,
                    ],
                ]
            ],
            '~nearly one year, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_YEAR - 1,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            '~nearly one year, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_YEAR - 1,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_MONTH,
                        'value' => 11,
                    ],
                    [
                        'unit' => Units::UNIT_DAY,
                        'value' => 30,
                    ],
                ]
            ],
            '~one year, precision=1' => [
                'valueInSeconds' => Durations::SECONDS_PER_YEAR,
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            '~one year, precision=2' => [
                'valueInSeconds' => Durations::SECONDS_PER_YEAR,
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_MONTH,
                        'value' => 11,
                    ],
                    [
                        'unit' => Units::UNIT_DAY,
                        'value' => 30,
                    ],
                ]
            ],
            '~one and a half years, precision=1' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_YEAR * 1.5),
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_YEAR,
                        'value' => 1,
                    ],
                ]
            ],
            '~one and a half years, precision=2' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_YEAR * 1.5),
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_YEAR,
                        'value' => 1,
                    ],
                    [
                        'unit' => Units::UNIT_MONTH,
                        'value' => 6,
                    ],
                ]
            ],
            '~3.4 years, precision=1' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_YEAR * 3.4),
                'precision' => 1,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_YEAR,
                        'value' => 3,
                    ],
                ]
            ],
            '~3.4 years, precision=2' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_YEAR * 3.4),
                'precision' => 2,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_YEAR,
                        'value' => 3,
                    ],
                    [
                        'unit' => Units::UNIT_MONTH,
                        'value' => 5,
                    ],
                ]
            ],
            '~3.4 years, precision=3' => [
                'valueInSeconds' => (int) (Durations::SECONDS_PER_YEAR * 3.4),
                'precision' => 3,
                'expectedUnits' => [
                    [
                        'unit' => Units::UNIT_YEAR,
                        'value' => 3,
                    ],
                    [
                        'unit' => Units::UNIT_MONTH,
                        'value' => 4,
                    ],
                    [
                        'unit' => Units::UNIT_DAY,
                        'value' => 23,
                    ],
                ]
            ],
        ];
    }
}
