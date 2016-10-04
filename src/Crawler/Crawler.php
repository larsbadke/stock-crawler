<?php

namespace StockCrawler;

class Crawler
{

    private $conditions;

    private $stocks;

    protected $results;

    public function __construct(Conditions $conditions, $stocks)
    {
        $this->conditions = $conditions;

        $this->stocks = $stocks;

    }

    public function results()
    {
        return $this->results = $this->run();
    }

    public function run()
    {
        $results = [];

        foreach ($this->stocks as $stock)
        {
            foreach ($stock->data as $index => $data)
            {
                foreach ($this->conditions->get() as $condition)
                {
                    $condition = Condition::parse($condition);

                    var_dump($condition);
                    echo '<br>';
                }

            }


        }




        return [];
    }


}
