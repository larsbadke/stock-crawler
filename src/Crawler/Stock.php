<?php

namespace StockCrawler;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Stock
{
    protected $stock;

    public function __construct($stock)
    {
        $this->stock = $this->toObject($stock);
    }
    
    public function name()
    {
        return $this->stock->name;
    }

    public function isin()
    {
        return $this->stock->isin;
    }

    public function quotes($from = '01.01.1970', $to = '01.01.2100', $sort = 'desc')
    {
        $filtered = collect($this->stock->data)->filter(function ($value, $key) use ($from, $to){

            return ($value->datetime >= Carbon::parse($from)) && ($value->datetime <= Carbon::parse($to));
        });

        return $this->sort($filtered, $sort);
    }

    public function last($from = '01.01.1970', $days = 5)
    {
        return $this->quotes('01.01.1900', $from, 'desc')->take($days);
    }

    protected function sort($data, $by = 'desc')
    {
        if(!$data instanceof Collection){

            $data = collect($data);
        }

        if($by == 'desc'){

            return $data->sortByDesc('datetime');
        }

        return $data->sortBy('datetime');
    }

    protected function toObject($array)
    {
        $json = json_encode($array);

        return json_decode($json);
    }

}