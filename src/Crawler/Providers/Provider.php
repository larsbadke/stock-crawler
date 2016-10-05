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

    protected $stock;


    public function __construct($stock, $quote)
    {
        $this->stock = $stock;
        
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