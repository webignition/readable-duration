<?php

use webignition\ReadableDuration\ReadableDuration;

class GetHoursTest extends BaseTest {     
    
    public function testPositiveZeroHours() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(120);
        
        $this->assertEquals(0, $readableDuration->getHours());        
        $this->assertTrue($readableDuration->isFuture());
    }
    
    public function testNegativeZeroHours() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(-120);
        
        $this->assertEquals(0, $readableDuration->getHours());        
        $this->assertFalse($readableDuration->isFuture());
    }    
    
    public function testPositiveOneHour() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60);
        
        $this->assertEquals(1, $readableDuration->getHours());            
        $this->assertTrue($readableDuration->isFuture());
    }
    
    public function testNegativeOneHour() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * -1);
        
        $this->assertEquals(1, $readableDuration->getHours());            
        $this->assertFalse($readableDuration->isFuture());
    }   
    
}