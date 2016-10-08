<?php

namespace StockCrawler\Providers;

use StockCrawler\Helpers\SMA;
use StockCrawler\Helpers\RSI;
use StockCrawler\Helpers\ROC;

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

    public function roc($period)
    {
        $quotes = $this->stock->last($this->quote->datetime, $period + 1);

        return ROC::calculate($quotes, $period);
    }
}