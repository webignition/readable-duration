<?php

namespace webignition\ReadableDuration;

class ReadableDuration {
    
    const SECONDS_PER_MINUTE = 60;
    const MINUTES_PER_HOUR = 60;
    const HOURS_PER_DAY = 24;
    const DAYS_PER_MONTH = 30; // approximate!
    const MONTHS_PER_YEAR = 12;
    
    
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
        
        $currentTime = new \DateTime();
        
        if ($valueInSeconds === 0) {
            $comparatorTime = $currentTime;
        } else {
            $comparatorTime = new \DateTime('+'.$valueInSeconds.' second');
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
        return $this->getInSeconds() / $this->getSecondsPerYear();
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
     * @return int
     */    
    public function getDays() {
        return $this->interval->d;
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
     * @return int
     */    
    public function getMinutes() {        
        return $this->interval->i;        
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
        $inSeconds  = $this->getSeconds();
        $inSeconds += $this->getMinutes() * self::SECONDS_PER_MINUTE;
        $inSeconds += $this->getHours() * $this->getSecondsPerHour();
        $inSeconds += $this->getDays() * $this->getSecondsPerDay();
        $inSeconds += $this->getMonths() * $this->getSecondsPerMonth();
        $inSeconds += $this->getYears() * $this->getSecondsPerYear();
        
        return $inSeconds;
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
        return $this->getSecondsPerDay() * self::DAYS_PER_MONTH;
    }
    
    
    /**
     * 
     * @return int
     */
    private function getSecondsPerYear() {
        return $this->getSecondsPerMonth() * self::MONTHS_PER_YEAR;
    }

}
