<?php

namespace StockCrawler;

class Stock
{
    private $stock;

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

    public function quotes()
    {
        return collect($this->stock->data);
    }

    public function toObject($array)
    {
        // First we convert the array to a json string
        $json = json_encode($array);

        // The we convert the json string to a stdClass()
        $object = json_decode($json);

        return $object;
    }

}