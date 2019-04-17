<?php

namespace webignition\Tests\ReadableDuration;

use webignition\ReadableDuration\Factory;
use webignition\ReadableDuration\ReadableDurationResult;

class FactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $factory = new Factory();

        $readableDuration = $factory->create(0);

        $this->assertInstanceOf(ReadableDurationResult::class, $readableDuration);
    }
}
