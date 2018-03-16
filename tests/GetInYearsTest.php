<?php

use webignition\ReadableDuration\ReadableDuration;

class GetInYearsTest extends BaseTest {     
    
    public function testOneSecondInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1);
        
        $this->assertEquals(0, $readableDuration->getInYears());
    }   
    
    public function testOneMinuteInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60);
        
        $this->assertEquals(0, $readableDuration->getInYears());
    }    
    
    public function testOneHourInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60);
        
        $this->assertEquals(0, $readableDuration->getInYears());
    }    
    
    public function testOneDayInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24);
        
        $this->assertEquals(0, $readableDuration->getInYears());
    }    
     
    public function testOneMonthInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * (365.25 / 12));
        
        $this->assertEquals(0, $readableDuration->getInYears());
    }    
    
    public function testOneYearInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 365);
        
        $this->assertEquals(1, $readableDuration->getInYears());
    }   
    
    public function testOnePointFiveYearInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds((60 * 60 * 24 * 365) * 1.5);
        
        $this->assertEquals(1, $readableDuration->getInYears());
    }     
    
    public function testOnePointSixYearInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds((60 * 60 * 24 * 365) * 1.6);
        
        $this->assertEquals(2, $readableDuration->getInYears());
    }      
    
    public function testOnePointNineYearInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds((60 * 60 * 24 * 365) * 1.9);
        
        $this->assertEquals(2, $readableDuration->getInYears());
    }       
    
    public function testTwoYearInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds((60 * 60 * 24 * 365) * 2);
        
        $this->assertEquals(2, $readableDuration->getInYears());
    }     
    
    public function testTwoPointOneYearInYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds((60 * 60 * 24 * 365) * 2.1);
        
        $this->assertEquals(2, $readableDuration->getInYears());
    }    
        
}