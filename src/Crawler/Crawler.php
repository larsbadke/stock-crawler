<?php

namespace StockCrawler;

use Carbon\Carbon;

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

        $this->compiler = new Compiler();
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

    protected function fetchQuotes($quotes)
    {
        return $quotes->filter(function ($value, $key) {

            return ($value->datetime >= $this->from) && ($value->datetime <= $this->to);
        });
    }

    public function run()
    {
        $results = [];

        foreach ($this->stocks as $stock)
        {
            $quotes = $this->fetchQuotes($stock->data);

            foreach ($quotes as $index => $quote)
            {
                foreach ($this->conditions->get() as $condition)
                {
                    $compiled = $this->compiler->parse($condition, $quote);
                    
                    if($this->compiler->isTrue($compiled)){
                        
                        array_push($results, $quote);
                    }

                    echo $compiled.'<br>';
                }
            }
        }
        
        return $results;
    }


}
