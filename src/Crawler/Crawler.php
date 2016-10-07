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

    protected function run()
    {
        $results = [];

        foreach ($this->stocks as $stock)
        {
            $stock = new Stock($stock);

            $quotes = $stock->quotes($this->from, $this->to, 'asc');

            foreach ($quotes as $index => $quote)
            {
                $counter = 0;
                
                foreach ($this->conditions->get() as $condition)
                {
                    $compiler = new Compiler($stock, $quote);
                    
                    $compiled = $compiler->parse($condition);

                    //todo check complied functions values
                    $log = 'Date: '.$quote->datetime.' ';
                    $log .= 'Stock: '.$stock->name().' ';
                    $log .= 'Condition: '.$condition.' ';
                    $log .= 'Compiled: '.$compiled.' ';

                    if($compiler->isTrue($compiled)){

                        $log .= ' - True';
                        $counter++;
                    }

                    \Illuminate\Support\Facades\Log::info('Check - '.$log);
                }
                
                if($counter == $this->conditions->count()){
                    
                    array_push($results, $quote);
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
