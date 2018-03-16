<?php

use webignition\ReadableDuration\ReadableDuration;

class GetInMostAppropriateUnitsTestWithPrecisionTwo extends BaseTest {         
    
    public function test100SecondsReturns1Minute40SecondsWithPrecision2() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(100);
        
        $this->assertEquals(array(
            array(
                'unit' => 'minute',
                'value' => 1
            ),
            array(
                'unit' => 'second',
                'value' => 40
            )            
        ), $readableDuration->getInMostAppropriateUnits(2));      
    } 
    
    
    public function test5009SecondsReturns1Hour23MinutesWithPrecision2() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(5009);
        
        $this->assertEquals(array(
            array(
                'unit' => 'hour',
                'value' => 1
            ),
            array(
                'unit' => 'minute',
                'value' => 23
            )            
        ), $readableDuration->getInMostAppropriateUnits(2));
    }    
   
    
    public function test5030SecondsReturns1Hour24MinutesWithPrecision2() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(5030);
        
        $this->assertEquals(array(
            array(
                'unit' => 'hour',
                'value' => 1
            ),
            array(
                'unit' => 'minute',
                'value' => 24
            )            
        ), $readableDuration->getInMostAppropriateUnits(2));
    }
    
    
    public function test1200580SecondsReturns13Days21HoursWithPrecision2() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1200580);
        
        $this->assertEquals(array(
            array(
                'unit' => 'day',
                'value' => 13
            ),
            array(
                'unit' => 'hour',
                'value' => 21
            )            
        ), $readableDuration->getInMostAppropriateUnits(2));      
    }    
    
    
    public function test1201000SecondsReturns13Days22HoursWithPrecision2() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(1201000);
        
        $this->assertEquals(array(
            array(
                'unit' => 'day',
                'value' => 13
            ),
            array(
                'unit' => 'hour',
                'value' => 22
            )            
        ), $readableDuration->getInMostAppropriateUnits(2));      
    }   
    
    
    public function test7200SecondsReturns2HoursWithPrecision2() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(7200);
        
        $this->assertEquals(array(
            array(
                'unit' => 'hour',
                'value' => 2
            )            
        ), $readableDuration->getInMostAppropriateUnits(2));      
    }  
    
    
    public function test7199SecondsReturns2HoursWithPrecision2000() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(7199);
        
        $this->assertEquals(array(
            array(
                'unit' => 'hour',
                'value' => 2
            )            
        ), $readableDuration->getInMostAppropriateUnits(2));      
    }      
}