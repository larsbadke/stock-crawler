<?php

namespace StockCrawler\Helpers;

use Illuminate\Support\Collection;

class SMA
{
    public static function calculate($quotes, $period = 20, $round = 2)
    {
        if(!$quotes instanceof Collection){
            
            $quotes = collect($quotes);
        }

        return round($quotes->take($period)->avg('close'), $round);
    }
}