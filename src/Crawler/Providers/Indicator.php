<?php

namespace StockCrawler\Providers;



use StockCrawler\Helpers\SMA;

class Indicator extends Provider
{
    
    public function sma($period)
    {
        $data = $this->stock->quotes()->take($period);

        return SMA::calculate($data, $period, 2);
    }

    public function rsi($period)
    {
        return 'rsi-'.$period;
    }

}