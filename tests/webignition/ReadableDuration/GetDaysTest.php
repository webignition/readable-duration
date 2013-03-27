<?php

use webignition\ReadableDuration\ReadableDuration;

class GetDaysTest extends BaseTest {     
    
    public function testPositiveZeroDays() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(3600);
        
        $this->assertEquals(0, $readableDuration->getDays());        
        $this->assertTrue($readableDuration->isFuture());
    }
    
    public function testNegativeZeroDays() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(-3600);
        
        $this->assertEquals(0, $readableDuration->getDays());        
        $this->assertFalse($readableDuration->isFuture());
    }    
    
    public function testPositiveOneDay() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24);
        
        $this->assertEquals(1, $readableDuration->getDays());            
        $this->assertTrue($readableDuration->isFuture());
    }
    
    public function testNegativeOneDay() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * -1);
        
        $this->assertEquals(1, $readableDuration->getDays());            
        $this->assertFalse($readableDuration->isFuture());
    }   
    
}