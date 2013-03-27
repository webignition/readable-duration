<?php

use webignition\ReadableDuration\ReadableDuration;

class GetInMonthssTest extends BaseTest {     
    
    public function testOneSecondInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1);
        
        $this->assertEquals(3.858024691358E-7, $readableDuration->getInMonths());
    }   
    
    public function testOneMinuteInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60);
        
        $this->assertEquals(2.3148148148148E-5, $readableDuration->getInMonths());
    }    
    
    public function testOneHourInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60);
        
        $this->assertEquals(0.0014, round($readableDuration->getInMonths(), 4));
    }    
    
    public function testOneDayInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24);
        
        $this->assertEquals(0.033, round($readableDuration->getInMonths(), 3));
    }    
     
    public function testOneMonthInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 30);
        
        $this->assertEquals(1, $readableDuration->getInMonths());
    }    
    
    public function testOneYearInMonths() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 365);
        
        $this->assertEquals(12, $readableDuration->getInMonths());
    }   
        
}