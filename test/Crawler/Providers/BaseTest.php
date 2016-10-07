<?php

namespace StockCrawler\Test;

use StockCrawler\Providers\Base;
use StockCrawler\Stock;

class BaseTest extends \PHPUnit_Framework_TestCase{
    
    protected $base;
    
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

        $this->base = new Base($stock, $quote);
    }
    
    public function test_can_access_stock_price()
    {
        $this->assertEquals(87.54, $this->base->price());
    }

    public function test_can_access_stock_close_price()
    {
        $this->assertEquals(87.54, $this->base->close());
    }

    public function test_can_access_stock_open_price()
    {
        $this->assertEquals(88.12, $this->base->open());
    }

    public function test_can_access_stock_low_price()
    {
        $this->assertEquals(86.09, $this->base->low());
    }

    public function test_can_access_stock_high_price()
    {
        $this->assertEquals(88.26, $this->base->high());
    }

    public function test_can_access_stock_volume()
    {
        $this->assertEquals(1266864, $this->base->volume());
    }
}