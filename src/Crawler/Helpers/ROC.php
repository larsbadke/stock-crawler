<?php

namespace StockCrawler\Helpers;

use Illuminate\Support\Collection;

class ROC
{
    public static function calculate($quotes, $period = 10, $price = 'close', $round = 2)
    {
        if(!$quotes instanceof Collection){

            $quotes = collect($quotes);
        }

        $quotes = $quotes->take($period+1)->pluck($price);

        if($quotes->count() < $period + 1){

            throw new \Exception('Not enough data');
        }

        $roc = $quotes->first() / $quotes->last() *100 -100 ;
        
        return round($roc, $round);
    }
}