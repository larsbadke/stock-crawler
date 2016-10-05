<?php

namespace StockCrawler\Helpers;

use Illuminate\Support\Collection;

class RSI
{
    public static function calculate($quotes, $period = 14, $round = 2)
    {
        if(!$quotes instanceof Collection){

            $quotes = collect($quotes);
        }

        $quotes = array_values($quotes->take($period+1)->toArray());
        
        if(count($quotes) != $period+1){
            //TODO ERROR HANDLING
            return 'error';
        }

        $ups = [];

        $downs = [];

        foreach ($quotes as $index => $quote)
        {
            if($index == $period){

                break;
            }

            if($quote->close >= $quotes[$index+1]->close)
            {
                $ups[]= $quote->close - $quotes[$index+1]->close;
                $downs[]=0;
            } else{
                $ups[]= 0;
                $downs[]= $quotes[$index+1]->close - $quote->close;
            }
        }

        $avgSU = collect($ups)->reverse()->take($period)->avg();

        $avgSD = collect($downs)->reverse()->take($period)->avg();

        return round(100 *($avgSU)/($avgSU+$avgSD), $round);
    }
}