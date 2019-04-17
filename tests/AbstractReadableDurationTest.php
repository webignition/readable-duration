<?php

namespace webignition\Tests\ReadableDuration;

use webignition\ReadableDuration\ReadableDuration;

abstract class AbstractReadableDurationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ReadableDuration
     */
    protected $readableDuration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->readableDuration = new ReadableDuration();
    }
}
