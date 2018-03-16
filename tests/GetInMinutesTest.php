<?php

use webignition\ReadableDuration\ReadableDuration;

class GetInMinutesTest extends BaseTest {     
    
    public function testOneSecondInMinutes() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1);
        
        $this->assertEquals(0, $readableDuration->getInMinutes());
    }   
    
    public function testOneMinuteInMinutes() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60);
        
        $this->assertEquals(1, $readableDuration->getInMinutes());
    }    
    
    public function testOneHourInMinutes() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60);
        
        $this->assertEquals(60, $readableDuration->getInMinutes());
    }    
    
    public function testOneDayInMinutes() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24);
        
        $this->assertEquals(1440, $readableDuration->getInMinutes());
    }    
     
    public function testOneMonthInMinutes() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * (365.25 / 12));
        
        $this->assertEquals(43830, $readableDuration->getInMinutes());
    }    
    
    public function testOneYearInMinutes() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 365.25);
        
        $this->assertEquals(525960, $readableDuration->getInMinutes());
    }   
        
}