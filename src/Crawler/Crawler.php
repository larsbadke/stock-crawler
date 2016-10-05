<?php

namespace StockCrawler;

use Carbon\Carbon;
use DateTime;

class Crawler
{
    protected $conditions;

    protected $stocks;

    protected $results;

    protected $from;

    protected $to;

    public function __construct($stocks, $conditions)
    {
        $this->conditions = new Conditions($conditions);
        //todo create new stocks class
        $this->stocks = $stocks;

        $this->from('01.01.1970');

        $this->to((new DateTime('now'))->format('d.m.Y'));
    }

    public function run()
    {
        $results = [];

        foreach ($this->stocks as $stock)
        {
            $stock = new Stock($stock);
            
            $quotes = $this->fetchQuotes($stock->quotes());

            foreach ($quotes as $index => $quote)
            {
                foreach ($this->conditions->get() as $condition)
                {
                    $compiler = new Compiler($stock, $quote);
                    
                    $compiled = $compiler->parse($condition);

                    if($compiler->isTrue($compiled)){

                        array_push($results, $quote);
                    }

                    echo $compiled.'<br>';
                }
            }
        }

        return $results;
    }

    protected function fetchQuotes($quotes)
    {
        return $quotes->filter(function ($value, $key) {

            return ($value->datetime >= $this->from) && ($value->datetime <= $this->to);
        });
    }

    public function results()
    {
        return $this->results = $this->run();
    }

    public function from($date)
    {
        $this->from = Carbon::parse($date);

        return $this;
    }

    public function to($date)
    {
        $this->to = Carbon::parse($date);

        return $this;
    }


}
