<?php

use webignition\ReadableDuration\ReadableDuration;

class GetRoundedMinutesTest extends GetRoundedUnitTest {     
    
    public function test0SecondsRoundsTo0Minutes() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    
    
    public function test29SecondsRoundsTo0Minutes() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }     
    
    public function test30SecondsRoundsTo1Minutes() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }      
    
    public function test60SecondsRoundsTo1Minutes() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    
    
    public function test89SecondsRoundsTo1Minutes() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    
    
    public function test90SecondsRoundsTo2Minutes() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }     
    
    public function test200SecondsRoundsTo3Minutes() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }   
    
}