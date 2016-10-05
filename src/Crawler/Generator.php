<?php

namespace StockCrawler;

class Generator {
    
    protected $providers = array();

    protected $quote;

    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    public function addProvider($provider)
    {
        array_unshift($this->providers, $provider);
    }
    
    public function __get($property)
    {
        foreach ($this->providers as $provider){
            
            if(property_exists($provider, $property)){

                $class = new $provider($this->quote);
                
                return $class->$property;
            }
        }
        
        throw new \InvalidArgumentException(sprintf('Unable to find property "%s"', $property));
    }
    
    public function __call($method, $arguments = [])
    {
        foreach ($this->providers as $provider){

            if(method_exists($provider, $method)){

                $class = new $provider($this->quote);

                return call_user_func_array(array($class, $method), $arguments[0]);
            }
        }
        
        throw new \InvalidArgumentException(sprintf('Unable to find method "%s"', $method));
    }
}