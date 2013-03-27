<?php

use webignition\ReadableDuration\ReadableDuration;

class GetInYearsTest extends BaseTest {     
    
    public function testOneSecondInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1);
        
        $this->assertEquals(3.2150205761317E-8, $readableDuration->getInYears());
    }   
    
    public function testOneMinuteInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60);
        
        $this->assertEquals(1.929012345679E-6, $readableDuration->getInYears());
    }    
    
    public function testOneHourInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60);
        
        $this->assertEquals(0.000116, round($readableDuration->getInYears(), 6));
    }    
    
    public function testOneDayInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24);
        
        $this->assertEquals(0.0028, round($readableDuration->getInYears(), 4));
    }    
     
    public function testOneMonthInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 30);
        
        $this->assertEquals(0.083, round($readableDuration->getInYears(), 3));
    }    
    
    public function testOneYearInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 365);
        
        $this->assertEquals(1, $readableDuration->getInYears());
    }   
        
}