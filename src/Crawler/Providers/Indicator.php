<?php

namespace StockCrawler\Providers;



class Indicator extends Provider{
    
    
    public function __construct($quote)
    {
        parent::__construct($quote);
    }
    
    public function sma($period)
    {
        return 'sma-'.$period;
    }

    public function rsi($period)
    {
        return 'rsi-'.$period;
    }

}