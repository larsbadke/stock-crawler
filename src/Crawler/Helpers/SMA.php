<?php


namespace StockCrawler\Helpers;



class SMA 
{
    public static function calculate($data, $period = 20, $round = 2)
    {
//        dd($data->take($period));

        return round($data->take($period)->avg('close'), $round);
    }


}