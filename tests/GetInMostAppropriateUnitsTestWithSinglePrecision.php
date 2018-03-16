<?php

use webignition\ReadableDuration\ReadableDuration;

class GetInMostAppropriateUnitsTestWithSinglePrecision extends BaseTest {     
    
    public function testOneSecond() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1);
        
        $this->assertEquals(array(
            'value' => 1,
            'units' => 'second'
        ), $readableDuration->getInMostAppropriateUnits());
    }   
    
    
    public function testOneMinute() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60);
        
        $this->assertEquals(array(
            'value' => 1,
            'units' => 'minute'
        ), $readableDuration->getInMostAppropriateUnits());
    }     
    
    
    public function testOneHour() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60);
        
        $this->assertEquals(array(
            'value' => 1,
            'units' => 'hour'
        ), $readableDuration->getInMostAppropriateUnits());
    }
    
    public function testOneDay() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24);
        
        $this->assertEquals(array(
            'value' => 1,
            'units' => 'day'
        ), $readableDuration->getInMostAppropriateUnits());        
    }
    
    public function testOneMonth() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * (365.25 / 12));
        
        $this->assertEquals(array(
            'value' => 1,
            'units' => 'month'
        ), $readableDuration->getInMostAppropriateUnits());        
    }    
    
    public function testOneYear() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(60 * 60 * 24 * 365.25);
        
        $this->assertEquals(array(
            'value' => 1,
            'units' => 'year'
        ), $readableDuration->getInMostAppropriateUnits());        
    }   
    
    
    public function test150SecondsReturns3Minutes() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(150);
        
        $this->assertEquals(array(
            'value' => 3,
            'units' => 'minute'
        ), $readableDuration->getInMostAppropriateUnits());         
    }
    
    public function test4000SecondsReturns1Hour() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(4000);
        
        $this->assertEquals(array(
            'value' => 1,
            'units' => 'hour'
        ), $readableDuration->getInMostAppropriateUnits());         
    } 
}