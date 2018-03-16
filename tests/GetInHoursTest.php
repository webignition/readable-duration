<?php

use webignition\ReadableDuration\ReadableDuration;

class GetInHoursTest extends BaseTest {     
    
    public function testOneSecondInHours() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1);
        
        $this->assertEquals(0, $readableDuration->getInHours());
    }   
    
    public function testOneMinuteInHours() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60);
        
        $this->assertEquals(0, $readableDuration->getInHours());
    }    
    
    public function testOneHourInHours() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60);
        
        $this->assertEquals(1, $readableDuration->getInHours());
    }    
    
    public function testOneDayInHours() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24);
        
        $this->assertEquals(24, $readableDuration->getInHours());
    }    
     
    public function testOneMonthInHours() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * (365.25 / 12));
        
        $this->assertEquals(731, $readableDuration->getInHours());
    }    
    
    public function testOneYearInHours() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 365.25);
        
        $this->assertEquals(8766, $readableDuration->getInHours());
    }   
        
}