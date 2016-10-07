<?php

namespace StockCrawler\Test;

use StockCrawler\Helpers\SMA;

class SMATest extends \PHPUnit_Framework_TestCase{
    
    protected $quotes;
    
    public function setUp()
    {
        $this->quotes = [
            [
                'open' => 100,
                'close' => 110,
            ],
            [
                'open' => 110,
                'close' => 120,
            ],
            [
                'open' => 120,
                'close' => 125,
            ],
            [
                'open' => 125,
                'close' => 110,
            ],
            [
                'open' => 115,
                'close' => 140,
            ],
        ];
    }
    
    public function test_calculation_of_close_quotes()
    {
        $sma5 = SMA::calculate($this->quotes, 5, 'close', 2);
        
        $this->assertEquals(121, $sma5);
    }

    public function test_calculation_of_open_quotes()
    {
        $sma5 = SMA::calculate($this->quotes, 5, 'open', 2);

        $this->assertEquals(114, $sma5);
    }

    public function test_calculation_with_lower_period()
    {
        $sma5 = SMA::calculate($this->quotes, 3, 'open', 2);

        $this->assertEquals(110, $sma5);
    }
    
    public function test_calculation_with_not_enough_data()
    {
        $sma5 = SMA::calculate($this->quotes, 10, 'open', 2);

        $this->assertEquals('not enough data', $sma5);
    }
}