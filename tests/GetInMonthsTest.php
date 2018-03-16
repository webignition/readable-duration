<?php

use webignition\ReadableDuration\ReadableDuration;

class GetInMonthsTest extends BaseTest {     
    
    public function testOneSecondInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1);
        
        $this->assertEquals(0, $readableDuration->getInMonths());
    }   
    
    public function testOneMinuteInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60);
        
        $this->assertEquals(0, $readableDuration->getInMonths());
    }    
    
    public function testOneHourInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60);
        
        $this->assertEquals(0, $readableDuration->getInMonths());
    }    
    
    public function testOneDayInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24);
        
        $this->assertEquals(0, $readableDuration->getInMonths());
    }    
     
    public function testOneMonthInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * (365.25 / 12));
        
        $this->assertEquals(1, $readableDuration->getInMonths());
    }    
    
    public function testOneYearInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 365);
        
        $this->assertEquals(12, $readableDuration->getInMonths());
    }   
        
}