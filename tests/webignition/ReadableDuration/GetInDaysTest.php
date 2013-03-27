<?php

use webignition\ReadableDuration\ReadableDuration;

class GetInDaysTest extends BaseTest {     
    
    public function testOneSecondInDays() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1);
        
        $this->assertEquals(0, $readableDuration->getInDays());
    }   
    
    public function testOneMinuteInDays() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60);
        
        $this->assertEquals(0, $readableDuration->getInDays());
    }    
    
    public function testOneHourInDays() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60);
        
        $this->assertEquals(0, $readableDuration->getInDays());
    }    
    
    public function testOneDayInDays() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24);
        
        $this->assertEquals(1, $readableDuration->getInDays());
    }    
     
    public function testOneMonthInDays() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * (365.25 / 12));
        
        $this->assertEquals(30, $readableDuration->getInDays());
    }    
    
    public function testOneYearInDays() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 365);
        
        $this->assertEquals(365, $readableDuration->getInDays());
    }   
        
}