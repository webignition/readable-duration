<?php

namespace webignition\Tests\ReadableDuration;

use webignition\ReadableDuration\ReadableDuration;

abstract class AbstractReadableDurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReadableDuration
     */
    protected $readableDuration;

    protected function setUp()
    {
        parent::setUp();

        $this->readableDuration = new ReadableDuration();
    }
}
