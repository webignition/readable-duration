<?php

class DemoTest extends BaseTest {
    
    /**
     * 100000 seconds is 1 day, 3 hours, 46 minutes and 40 seconds
     */
    public function testGetNumberOfYearsMonthsDaysHoursHoursMinutesSeconds() {
        $readableDuration = new \webignition\ReadableDuration\ReadableDuration();
        $readableDuration->setValueInSeconds(100000);    
        
        $this->assertEquals(1, $readableDuration->getDays());
        $this->assertEquals(3, $readableDuration->getHours());
        $this->assertEquals(46, $readableDuration->getMinutes());
        $this->assertEquals(40, $readableDuration->getSeconds());
    } 
    
    
    /**
     * 100000 seconds as years, months, days, hours, minute or seconds
     * 
     * Note: these are human-readable convenience representatons not exact
     * 
     * 100000 seconds is strictly 1.16 days. As far as convenience is concerned, that's 1 day.
     * 100000 seconds is strictly 27.78 hours. As far as convenience is concerned, that's 28 hours.
     */
    public function testGetInYearsMonthsDaysHoursMinutesOrSeconds() {
        $readableDuration = new \webignition\ReadableDuration\ReadableDuration();
        $readableDuration->setValueInSeconds(100000);    
        
        $this->assertEquals(0, $readableDuration->getInYears());
        $this->assertEquals(0, $readableDuration->getInMonths());
        $this->assertEquals(1, $readableDuration->getInDays());
        $this->assertEquals(28, $readableDuration->getInHours());
        $this->assertEquals(1667, $readableDuration->getInMinutes());
        $this->assertEquals(100000, $readableDuration->getInSeconds());        
     
    }
    
    
    /**
     * 100000 seconds:
     * 
     * - represented as a single time unit is 1 day
     * - represented as two time units is 1 day 4 hours
     * - represented as three time units is 1 day 3 hours 47 minutes
     * 
     */
    public function testGetAsTheMostAppropriateHumanValue() {
        $readableDuration = new \webignition\ReadableDuration\ReadableDuration();
        $readableDuration->setValueInSeconds(100000);  
        
        /**
         * 100000 seconds, as a single time unit is 1 day
         */
        $this->assertEquals(array(
            array(
                'unit' => 'day',
                'value' => 1
            )
        ), $readableDuration->getInMostAppropriateUnits());
        

        /**
         * 100000 seconds, as two time units is 1 day 4 hours
         */
        $this->assertEquals(array(
            array(
                'unit' => 'day',
                'value' => 1
            ),            
            array(
                'unit' => 'hour',
                'value' => 4
            )
        ), $readableDuration->getInMostAppropriateUnits(2)); 
        
        
        /**
         * 100000 seconds, as three time units is 1 day 3 hours 47 minutes
         */
        $this->assertEquals(array(
            array(
                'unit' => 'day',
                'value' => 1
            ),            
            array(
                'unit' => 'hour',
                'value' => 3
            ),
            array(
                'unit' => 'minute',
                'value' => 47
            )            
        ), $readableDuration->getInMostAppropriateUnits(3));        
    }
    
}