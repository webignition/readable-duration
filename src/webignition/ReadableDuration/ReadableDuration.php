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
        
        $this->interval = $currentTime->diff($comparatorTime);
        
        return $this;
    }
    
    
    /**
     * 
     * @return int
     */
    public function getYears() {
        return (int)$this->interval->format('%y');
    }

}
