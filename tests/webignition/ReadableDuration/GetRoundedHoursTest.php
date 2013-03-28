<?php

use webignition\ReadableDuration\ReadableDuration;

class GetRoundedHoursTest extends GetRoundedUnitTest {     
    
    public function test0SecondsRoundsTo0Hours() {        
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }        
    
    public function test1799SecondsRoundsTo0Hours() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    
    
    public function test1800SecondsRoundsTo1Hours() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }     
    
    public function test1801SecondsRoundsTo1Hours() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }     
    

    public function test3599SecondsRoundsTo1Hours() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }      
    
    
    public function test3600SecondsRoundsTo1Hours() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }     
    

    public function test5399SecondsRoundsTo1Hours() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    
    
    
    public function test5400SecondsRoundsTo2Hours() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    
    
}