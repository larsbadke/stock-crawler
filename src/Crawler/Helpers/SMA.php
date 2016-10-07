<?php

namespace StockCrawler\Helpers;

use Illuminate\Support\Collection;

class SMA
{
    public static function calculate($quotes, $period = 20, $price = 'close', $round = 2)
    {
        if(!$quotes instanceof Collection){
            
            $quotes = collect($quotes);
        }
        
        if($quotes->count() < $period){

            throw new \Exception('not enough Data');
        }

        return round($quotes->take($period)->avg($price), $round);
    }
}