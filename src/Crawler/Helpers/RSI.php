<?php

namespace StockCrawler\Helpers;

use Illuminate\Support\Collection;

class RSI
{
    public static function calculate($quotes, $period = 14, $price = 'close', $round = 2)
    {
        if(!$quotes instanceof Collection){

            $quotes = collect($quotes);
        }

        $quotes = $quotes->take($period+1)->pluck($price);

        if($quotes->count() < $period + 1){

            return 'not enough data';
        }
        
        $upsAndDowns = static::calculateUpAndDowns($quotes->toArray(), $period);

        $avgSU = collect($upsAndDowns['ups'])->avg();

        $avgSD = collect($upsAndDowns['downs'])->avg();

        return round(100 *($avgSU)/($avgSU+$avgSD), $round);
    }


    public static function calculateUpAndDowns($quotes, $period)
    {
        $ups = $downs = [];
        
        foreach ($quotes as $index => $quote)
        {
            if($index == $period){break;}

            if($quote >= $quotes[$index+1])
            {
                $ups[]= $quote - $quotes[$index+1];
                $downs[]=0;
            } else{
                $ups[]= 0;
                $downs[]= $quotes[$index+1] - $quote;
            }
        }
        
        return array(
            'ups' => $ups,
            'downs' => $downs,
        );
    }
}