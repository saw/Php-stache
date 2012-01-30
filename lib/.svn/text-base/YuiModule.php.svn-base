<?php

/**
 * simple wrapper to help define a yui module that a controller might need
 */
class YuiModule {
    
    public $name;
    
    public $path;
    
    public $initCode = false;
    
    public $order = 10;
    
    public function __construct($name){
        $this->name = $name;
        
        $this->path = '/javascript/'. $name . '.source.js';
    }
    
    public function setPath($path){
        $this->path = $path;
    }
    
    public function setInitCode($code){
        $this->initCode = $code;
    }
    
}