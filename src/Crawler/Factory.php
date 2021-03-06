<?php

namespace StockCrawler;

class Factory
{
    protected static $defaultProviders = array('Base', 'Indicator', 'Candlestick');
    
    public static function create($stock, $quote)
    {
        $generator = new Generator($stock, $quote);
        
        foreach (static::$defaultProviders as $provider) {
            
            $providerClassName = self::getProviderClassname($provider);
            
            $generator->addProvider($providerClassName);
        }
        
        return $generator;
    }
    
    protected static function getProviderClassname($provider)
    {
        $providerClass = 'StockCrawler\\Providers\\' . $provider;
        
        if (class_exists($providerClass)) {
            
            return $providerClass;
        }
        
        throw new \InvalidArgumentException(sprintf('Unable to find provider "%s"', $provider));
    }
}