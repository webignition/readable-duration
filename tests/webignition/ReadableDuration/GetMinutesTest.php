<?php

use webignition\ReadableDuration\ReadableDuration;

class GetMinutesTest extends BaseTest {     
    
    public function testPositiveZeroMinutes() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(50);
        
        $this->assertEquals(0, $readableDuration->getMinutes());        
        $this->assertTrue($readableDuration->isFuture());
    }
    
    public function testNegativeZeroMinutes() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(-50);
        
        $this->assertEquals(0, $readableDuration->getMinutes());        
        $this->assertFalse($readableDuration->isFuture());
    }    
    
    public function testPositiveOneMinute() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60);
        
        $this->assertEquals(1, $readableDuration->getMinutes());            
        $this->assertTrue($readableDuration->isFuture());
    }
    
    public function testNegativeOneMinute() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * -1);
        
        $this->assertEquals(1, $readableDuration->getMinutes());            
        $this->assertFalse($readableDuration->isFuture());
    }   
    
}