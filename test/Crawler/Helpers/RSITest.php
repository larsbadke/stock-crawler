<?php

namespace StockCrawler\Test;

use StockCrawler\Helpers\RSI;

class RSITest extends \PHPUnit_Framework_TestCase{
    
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
        $rsi4 = RSI::calculate($this->quotes, 4, 'close', 2);
        
        $this->assertEquals(25, $rsi4);
    }

    public function test_calculation_of_open_quotes()
    {
        $rsi4 = RSI::calculate($this->quotes, 4, 'open', 2);

        $this->assertEquals(28.57, $rsi4);
    }

    public function test_calculation_with_lower_period()
    {
        $rsi4 = RSI::calculate($this->quotes, 3, 'close', 2);

        $this->assertEquals(50, $rsi4);
    }

    public function test_calculation_with_not_enough_data()
    {
        $rsi4 = RSI::calculate($this->quotes, 10, 'close', 2);

        $this->assertEquals('not enough data', $rsi4);
    }
}