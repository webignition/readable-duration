<?php

namespace webignition\ReadableDuration;

class ReadableDuration {
    
    const SECONDS_PER_MINUTE = 60;
    const MINUTES_PER_HOUR = 60;
    const HOURS_PER_DAY = 24;   
    
    
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

}
