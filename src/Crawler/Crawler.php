<?php

namespace StockCrawler;

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
            
            $quotes = $stock->quotes($this->from, $this->to, 'asc');

            foreach ($quotes as $index => $quote)
            {
                foreach ($this->conditions->get() as $condition)
                {
                    $compiler = new Compiler($stock, $quote);
                    
                    $compiled = $compiler->parse($condition);

                    echo $index.' - '.$compiled.'<br>';

                    if($compiler->isTrue($compiled)){

                        array_push($results, $quote);
                    }
                }
            }
        }

        return $results;
    }

    public function results()
    {
        return $this->results = $this->run();
    }

    public function from($date)
    {
        $this->from = $date;

        return $this;
    }

    public function to($date)
    {
        $this->to = $date;

        return $this;
    }


}
