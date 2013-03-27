<?php

use webignition\ReadableDuration\ReadableDuration;

class GetYearsTest extends BaseTest {
    
    public function testPositiveZeroYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(3600);
        
        $this->assertEquals(0, $readableDuration->getYears());        
    }
    
    public function testNegativeZeroYears() {
        $readableDuration = new ReadableDuration();
        $readableDuration->setValueInSeconds(-3600);
        
        $this->assertEquals(0, $readableDuration->getYears());        
    }    
    
}