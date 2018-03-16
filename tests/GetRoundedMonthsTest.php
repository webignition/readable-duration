<?php

use webignition\ReadableDuration\ReadableDuration;

class GetRoundedMonthsTest extends GetRoundedUnitTest {     
    
    public function test0SecondsRoundsTo0Months() {
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }        
    
    public function test1382299SecondsRoundsTo0Months() {        
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }    
    
    public function test1382400SecondsRoundsTo1Months() {        
        $roundedMethodName = $this->getRoundedUnitMethodFromMethodName(__FUNCTION__);
        
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds($this->getSecondValueFromMethodName(__FUNCTION__));
        
        $this->assertEquals($this->getExpectedValueFromMethodName(__FUNCTION__), $readableDuration->$roundedMethodName());
    }  

    
}