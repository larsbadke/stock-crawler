<?php

namespace StockCrawler\Providers;

use StockCrawler\Helpers\SMA;
use StockCrawler\Helpers\RSI;

class Indicator extends Provider
{
    public function sma($period)
    {
        $quotes = $this->stock->last($this->quote->datetime, $period);

        return SMA::calculate($quotes, $period);
    }

    public function rsi($period)
    {
        $quotes = $this->stock->last($this->quote->datetime, $period + 1);
        
        return RSI::calculate($quotes, $period);
    }
}