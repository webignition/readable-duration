<?php

abstract class GetRoundedUnitTest extends BaseTest {    
    
    protected function getSecondValueFromMethodName($methodName) {
        $matches = array();
        preg_match_all('/test[0-9]*/', $methodName, $matches);
        
        return (int)str_replace('test', '', $matches[0][0]);
    }
    
    protected function getExpectedValueFromMethodName($methodName) {        
        $matches = array();
        preg_match_all('/[0-9]*(Minutes|Hours|Days|Months|Years)/', $methodName, $matches);
        
        return (int)str_replace(array('Minutes','Hours','Days','Months','Years'), '', $matches[0][0]);
    }
    
    protected function getRoundedUnitMethodFromMethodName($methodName) {        
        $matches = array();
        preg_match_all('/(Minutes|Hours|Days|Months|Years)/', $methodName, $matches);
        
        return 'getRounded'.$matches[0][0];
    }
    
    
}