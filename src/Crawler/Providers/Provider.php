<?php
namespace StockCrawler\Providers;


class Provider{
    /**
     * Rounds value of stock data to specified precision
     *
     * @var int
     */
    public $round = 2;
    
    protected $quote;


    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    /**
     * Set round precision
     *
     * @param $round
     */
    public function setRound($round)
    {
        $this->round = $round;
    }
}