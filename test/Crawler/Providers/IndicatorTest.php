<?php

namespace StockCrawler\Test;

use StockCrawler\Providers\Indicator;
use StockCrawler\Stock;

class IndicatorTest extends \PHPUnit_Framework_TestCase{
    
    protected $indicator;
    
    public function setUp()
    {
        $stockData = [
            'name' => 'Test Company Inc.',
            'isin' => 'US123456789',
            'data' => [
                [
                    "open" => 88.12,
                    "close" => 87.54,
                    "low" => 86.09,
                    "high" => 88.26,
                    "volume" => 1266864,
                    "datetime" => "2016-01-03 00:00:00",
                ],
                [
                    "open" => 89.12,
                    "close" => 86.54,
                    "low" => 85.09,
                    "high" => 88.26,
                    "volume" => 1266864,
                    "datetime" => "2016-01-02 00:00:00",
                ],
                [
                    "open" => 88.12,
                    "close" => 87.54,
                    "low" => 86.09,
                    "high" => 88.26,
                    "volume" => 1266864,
                    "datetime" => "2016-01-01 00:00:00",
                ],
                [
                    "open" => 88.12,
                    "close" => 87.54,
                    "low" => 86.09,
                    "high" => 88.26,
                    "volume" => 1266864,
                    "datetime" => "2015-12-31 00:00:00",
                ],
            ]
        ];
        
        $quote = [         
            "open" => 88.12,
            "close" => 87.54,
            "low" => 86.09,
            "high" => 88.26,
            "volume" => 1266864,
            "datetime" => "2016-01-03 00:00:00",
        ];

        $stock = new Stock($stockData);

        $this->indicator = new Indicator($stock, $quote);
    }
    
    public function test_can_access_sma()
    {
        $this->assertEquals(87.29, $this->indicator->sma(4));
    }

    public function test_can_access_rsi()
    {
        $this->assertEquals(50.00, $this->indicator->rsi(3));
    }
}