<?php

namespace webignition\ReadableDuration;

class ReadableDuration {
    
    const SECONDS_PER_MINUTE = 60;
    const MINUTES_PER_HOUR = 60;
    const HOURS_PER_DAY = 24;
    const DAYS_PER_MONTH = 30.44; // approximate!
    const MONTHS_PER_YEAR = 12;
    const DAYS_PER_YEAR = 365.25; // approximate!
    
    const MAX_APPROPRIATE_UNITS_PRECISION = 6;
    
    const UNIT_YEAR = 'year';
    const UNIT_MONTH = 'month';
    const UNIT_DAY = 'day';
    const UNIT_HOUR = 'hour';
    const UNIT_MINUTE = 'minute';
    const UNIT_SECOND = 'second';
    
    const INTERVAL_YEAR_KEY = 'y';
    const INTERVAL_MONTH_KEY = 'm';
    const INTERVAL_DAY_KEY = 'd';
    const INTERVAL_HOUR_KEY = 'h';
    const INTERVAL_MINUTE_KEY = 'i';
    const INTERVAL_SECOND_KEY = 's';
    
    
    /**
     *
     * @var int
     */
    private $valueInSeconds = 0;
    
    
    /**
     *
     * @var \DateInterval
     */
    private $interval = null;
    
    
    /**
     *
     * @var boolean 
     */
    private $isFuture = true;   
    
    
    /**
     *
     * @var array
     */
    private $units = array(
        self::UNIT_YEAR,
        self::UNIT_MONTH,
        self::UNIT_DAY,
        self::UNIT_HOUR,
        self::UNIT_MINUTE,
        self::UNIT_SECOND
    ); 
    
    
    private $intervalUnits = array(
        self::INTERVAL_YEAR_KEY,
        self::INTERVAL_MONTH_KEY,
        self::INTERVAL_DAY_KEY,
        self::INTERVAL_HOUR_KEY,
        self::INTERVAL_MINUTE_KEY,
        self::INTERVAL_SECOND_KEY     
    );
    
    
    private $unitsToIntervalUnits = array(
        self::UNIT_YEAR => self::INTERVAL_YEAR_KEY,
        self::UNIT_MONTH => self::INTERVAL_MONTH_KEY,
        self::UNIT_DAY => self::INTERVAL_DAY_KEY,
        self::UNIT_HOUR => self::INTERVAL_HOUR_KEY,
        self::UNIT_MINUTE => self::INTERVAL_MINUTE_KEY,
        self::UNIT_SECOND  => self::INTERVAL_SECOND_KEY,
    );
    
    
    /**
     * 
     * @param type $valueInSeconds
     */
    public function __construct($valueInSeconds = null) {
        $this->setValueInSeconds($valueInSeconds);
    }
    
    
    /**
     * 
     * @param type $valueInSeconds
     * @return \webignition\ReadableDuration\ReadableDuration
     */
    public function setValueInSeconds($valueInSeconds) {
        if (!is_scalar($valueInSeconds)) {
            $valueInSeconds = 0;
        } else {
            $valueInSeconds = (int)$valueInSeconds;
        }
        
        $this->valueInSeconds = $valueInSeconds;
        
        $currentTime = new \DateTime();
        
        if ($this->valueInSeconds === 0) {
            $comparatorTime = $currentTime;
        } else {
            $comparatorTime = new \DateTime('+'.$this->valueInSeconds.' second');
        }
        
        $this->isFuture = $currentTime <= $comparatorTime;        
        $this->interval = $currentTime->diff($comparatorTime);
        
        return $this;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function isFuture() {        
        if ($this->isPresent()) {
            return false;
        }
        
        return $this->interval->invert === 0;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function isPresent() {        
        return $this->getInSeconds() === 0;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function isPast() {
        if ($this->isPresent()) {
            return false;
        }
        
        return $this->interval->invert === 1;        
    }
    
    
    /**
     * 
     * @return int
     */
    public function getYears() {        
        return $this->interval->{self::INTERVAL_YEAR_KEY};
    }
    
    
    /**
     * 
     * @return int
     */
    public function getRoundedYears() {        
        $years = $this->getYears();
        $months = $this->getMonths();
        
        if ($months <= 6) {
            return $years;
        }
        
        return $years + 1;
    }  
    
    
    /**
     * 
     * @return double
     */
    public function getInYears() {        
        return (int)round($this->getInSeconds() / $this->getSecondsPerYear());
    }
    
    
    /**
     * 
     * @return int
     */
    public function getMonths() {
        return $this->interval->{self::INTERVAL_MONTH_KEY};
    }
    
    
    /**
     * 
     * @return int
     */
    public function getRoundedMonths() {        
        $months = $this->getMonths();
        $days = $this->getDays();
        
        
        if ($days <= 15) {
            return $months;
        }
        
        return $months + 1;
    }    
    
    
    /**
     * 
     * @return double
     */
    public function getInMonths() {        
        return (int)round($this->getInSeconds() / $this->getSecondsPerMonth());
    }
    
    
    /**
     * 
     * @return int
     */    
    public function getDays() {
        return $this->interval->{self::INTERVAL_DAY_KEY};
    }
    
    
    /**
     * 
     * @return int
     */
    public function getRoundedDays() {
        $days = $this->getDays();
        $hours = $this->getHours();        
        
        if ($hours <= 11) {
            return $days;
        }
        
        return $days + 1;
    }    
    
    
    /**
     * 
     * @return double
     */
    public function getInDays() {        
        return (int)round($this->getInSeconds() / $this->getSecondsPerDay());
    }    
    
    
    /**
     * 
     * @return int
     */    
    public function getHours() {
        return $this->interval->{self::INTERVAL_HOUR_KEY};       
    }
    

    /**
     * 
     * @return int
     */
    public function getRoundedHours() {
        $hours = $this->getHours();
        $minutes = $this->getMinutes();
        
        if ($minutes <= 29) {
            return $hours;
        }
        
        return $hours + 1;
    }    
    
    
    /**
     * 
     * @return double
     */
    public function getInHours() {        
        return (int)round($this->getInSeconds() / $this->getSecondsPerHour());
    }
    
    
    /**
     * 
     * @return int
     */    
    public function getMinutes() {        
        return $this->interval->{self::INTERVAL_MINUTE_KEY};        
    }
    
    
    /**
     * 
     * @return double
     */
    public function getInMinutes() {        
        return (int)round($this->getInSeconds() / self::SECONDS_PER_MINUTE);
    } 
    
    
    /**
     * 
     * @return int
     */
    public function getRoundedMinutes() {        
        $minutes = $this->getMinutes();
        $seconds = $this->getSeconds();
        
        if ($seconds <= 29) {
            return $minutes;
        }
        
        return $minutes + 1;
    }
    
    
    /**
     * 
     * @return int
     */    
    public function getSeconds() {
        return $this->interval->{self::INTERVAL_SECOND_KEY};
    }
    
    
    /**
     * 
     * @return int
     */
    public function getInSeconds() {
        return $this->valueInSeconds;
    }
    
    
    /**
     * 
     * @return int
     */
    private function getSecondsPerHour() {
        return self::SECONDS_PER_MINUTE * self::MINUTES_PER_HOUR;
    }
    
    
    
    /**
     * 
     * @return int
     */
    private function getSecondsPerDay() {
        return $this->getSecondsPerHour() * self::HOURS_PER_DAY;
    }  
    
    
    /**
     * 
     * @return int
     */
    private function getSecondsPerMonth() {
        return $this->getSecondsPerDay() * (self::DAYS_PER_YEAR / self ::MONTHS_PER_YEAR);
    }
    
    
    /**
     * 
     * @return int
     */
    private function getSecondsPerYear() {
        return $this->getSecondsPerDay() * self::DAYS_PER_YEAR;
    }
    
    
    public function getInMostAppropriateUnits($precision = 1) {        
        if (!is_scalar($precision)) {
            $precision = 1;
        }
        
        $precision = (int)round($precision);

        if ($precision > self::MAX_APPROPRIATE_UNITS_PRECISION) {
            $precision = self::MAX_APPROPRIATE_UNITS_PRECISION;
        }
        
        $currentInterval = clone $this->interval;
        
        $values = array();
        
        for ($precisionLevel = 0; $precisionLevel < $precision; $precisionLevel++) {
            if ($precisionLevel == $precision - 1) {
                if ($this->getLargestIntervalUnit() == 'second') {
                    $methodName = 'getSeconds';
                } else {
                    $methodName = 'getRounded'.ucwords($this->getLargestIntervalUnit()).'s';                
                }               
                
                $values[] = array(
                    'unit' => $this->getLargestIntervalUnit(),
                    'value' => $this->$methodName()
                );                
            } else {
                $values[] = array(
                    'unit' => $this->getLargestIntervalUnit(),
                    'value' => $this->interval->{$this->unitsToIntervalUnits[$this->getLargestIntervalUnit()]}
                );                
            }
            
            $this->interval->{$this->unitsToIntervalUnits[$this->getLargestIntervalUnit()]} = 0;
        }
        
        $this->interval = clone $currentInterval;
        
        return $values;
    }
    
    
    private function getLargestIntervalUnit() {
        $intervalUnits = array(
            'y' => 'year',
            'm' => 'month',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second'
        );        
        foreach ($intervalUnits as $intervalUnitKey => $unit) {
            if ($this->interval->$intervalUnitKey !== 0) {
                return $unit;
            }
        }
        
        return null;        
    }  
    

}
