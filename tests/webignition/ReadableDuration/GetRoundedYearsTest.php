<?php

use webignition\ReadableDuration\ReadableDuration;

class GetRoundedYearsTest extends GetRoundedUnitTest {     
    
    public function test10000000SecondsRoundsTo0Years() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }     
    
    public function test15000000SecondsRoundsTo0Years() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    
    
    public function test30000000SecondsRoundsTo1Years() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    
    
    public function test40000000SecondsRoundsTo1Years() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    
    
}