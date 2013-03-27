<?php

namespace webignition\ReadableDuration;

class ReadableDuration {
    
    const SECONDS_PER_MINUTE = 60;
    const MINUTES_PER_HOUR = 60;
    const HOURS_PER_DAY = 24;
    const DAYS_PER_MONTH = 30; // approximate!
    const MONTHS_PER_YEAR = 12;
    const DAYS_PER_YEAR = 365.25; // approximate!
    
    
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
        
        return $this->isFuture;
    }
    
    
    public function isPresent() {        
        foreach ($this->interval as $key => $value) {            
            if ($value !== 0) {
                return false;
            }
        }
        
        return true;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function isPast() {
        return !$this->isFuture() && $this->isPresent();
    }
    
    
    /**
     * 
     * @return int
     */
    public function getYears() {        
        return $this->interval->y;
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
        return $this->interval->m;
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
        return $this->interval->d;
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
        return $this->interval->h;        
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
        return $this->interval->i;        
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
    public function getSeconds() {
        return $this->interval->s;
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

}
