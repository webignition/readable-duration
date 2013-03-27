<?php

use webignition\ReadableDuration\ReadableDuration;

class GetSecondsTest extends BaseTest {     
    
    public function testPositiveZeroSeconds() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(0);
        
        $this->assertEquals(0, $readableDuration->getSeconds());        
        $this->assertTrue($readableDuration->isPresent());
    }
    
    public function testNegativeZeroSeconds() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(-0);
        
        $this->assertEquals(0, $readableDuration->getSeconds());        
        $this->assertTrue($readableDuration->isPresent());
    }    
    
    public function testPositiveOneSecond() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1);
        
        $this->assertEquals(1, $readableDuration->getSeconds());            
        $this->assertTrue($readableDuration->isFuture());
    }
    
    public function testNegativeOneSecond() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1 * -1);
        
        $this->assertEquals(1, $readableDuration->getSeconds());            
        $this->assertFalse($readableDuration->isFuture());
    }   
    
}