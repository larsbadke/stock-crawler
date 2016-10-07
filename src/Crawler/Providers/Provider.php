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
        
        if(!is_object($quote)){

            $quote = $this->toObject($quote);
        }
        
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

    private function toObject($array)
    {
        $json = json_encode($array);

        return json_decode($json);
    }
}