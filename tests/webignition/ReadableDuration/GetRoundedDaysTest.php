<?php

use webignition\ReadableDuration\ReadableDuration;

class GetRoundedDaysTest extends GetRoundedUnitTest {     
    
    public function test0SecondsRoundsTo0Days() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }        
    
    public function test43199SecondsRoundsTo0Days() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }     
    
    public function test43200SecondsRoundsTo1Days() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    
    
    public function test43201SecondsRoundsTo1Days() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }     
    
    public function test86400SecondsRoundsTo1Days() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }
    
    public function test86401SecondsRoundsTo1Days() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    

    
}