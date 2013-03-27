<?php

use webignition\ReadableDuration\ReadableDuration;

class GetInSecondsTest extends BaseTest {     
    
    public function testOneSecondInSeconds() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1);
        
        $this->assertEquals(1, $readableDuration->getInSeconds());
    }   
    
    public function testOneMinuteInSeconds() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60);
        
        $this->assertEquals(60, $readableDuration->getInSeconds());
    }      
    
    public function testOneHourInSeconds() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60);
        
        $this->assertEquals(3600, $readableDuration->getInSeconds());
    }    
    
    public function testOneDayInSeconds() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24);
        
        $this->assertEquals(86400, $readableDuration->getInSeconds());
    }    
     
    public function testOneMonthInSeconds() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * (365.25 / 12));
        
        $this->assertEquals(2629800, $readableDuration->getInSeconds());
    }    
    
    public function testOneYearInSeconds() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 365);
        
        $this->assertEquals(31536000, $readableDuration->getInSeconds());
    }   
        
}