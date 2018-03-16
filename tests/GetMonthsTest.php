<?php

use webignition\ReadableDuration\ReadableDuration;

class GetMonthsTest extends BaseTest {     
    
    public function testPositiveZeroMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(3600);
        
        $this->assertEquals(0, $readableDuration->getMonths());        
        $this->assertTrue($readableDuration->isFuture());
    }
    
    public function testNegativeZeroMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(-3600);
        
        $this->assertEquals(0, $readableDuration->getMonths());        
        $this->assertFalse($readableDuration->isFuture());
    }    
    
    public function testPositiveOneMonth() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 40);
        
        $this->assertEquals(1, $readableDuration->getMonths());            
        $this->assertTrue($readableDuration->isFuture());
    }
    
    public function testNegativeOneMonth() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 40 * -1);
        
        $this->assertEquals(1, $readableDuration->getMonths());            
        $this->assertFalse($readableDuration->isFuture());
    }   
    
}