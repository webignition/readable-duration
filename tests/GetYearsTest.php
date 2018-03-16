<?php

use webignition\ReadableDuration\ReadableDuration;

class GetYearsTest extends BaseTest {     
    
    public function testPositiveZeroYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(3600);
        
        $this->assertEquals(0, $readableDuration->getYears());        
        $this->assertTrue($readableDuration->isFuture());
    }
    
    public function testNegativeZeroYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(-3600);
        
        $this->assertEquals(0, $readableDuration->getYears());        
        $this->assertFalse($readableDuration->isFuture());
    }    
    
    public function testPositiveOneYear() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 400);
        
        $this->assertEquals(1, $readableDuration->getYears());            
        $this->assertTrue($readableDuration->isFuture());
    }
    
    public function testNegativeOneYear() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 400 * -1);
        
        $this->assertEquals(1, $readableDuration->getYears());            
        $this->assertFalse($readableDuration->isFuture());
    }    
    
}