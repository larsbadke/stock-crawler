<?php

namespace StockCrawler\Providers;

use StockCrawler\Helpers\SMA;

class Indicator extends Provider
{
    
    public function sma($period)
    {
        $quotes = $this->stock->last($this->quote->datetime, $period);

        return SMA::calculate($quotes, $period, 2);
    }

    public function rsi($period)
    {
        $quotes = $this->stock->last($this->quote->datetime, $period);
        
        //TODO add rsi
        
        return 'rsi-'.$period;
    }

}