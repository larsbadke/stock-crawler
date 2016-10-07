<?php

namespace StockCrawler\Test;


use StockCrawler\Stock;

class StockTest extends \PHPUnit_Framework_TestCase
{

    protected $stock;

    public function setUp()
    {
        $stock = [
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
        
        $this->stock = new Stock($stock);
    }
    
    public function test_get_stock_name()
    {
        $this->assertEquals('Test Company Inc.', $this->stock->name());
    }

    public function test_get_stock_isin()
    {
        $this->assertEquals('US123456789', $this->stock->isin());
    }
    
    public function test_get_all_stock_quotes()
    {
        $this->assertCount(4, $this->stock->quotes());
    }

    public function test_get_stock_quotes_with_date()
    {
        $this->assertCount(3, $this->stock->quotes('01.01.2016'));

        $this->assertCount(2, $this->stock->quotes('01.01.2016', '02.01.2016'));
    }

    public function test_get_stock_quotes_sorting()
    {
        $quotes = $this->stock->quotes('01.01.2016', '02.01.2016', 'desc');
        
        $this->assertEquals("2016-01-02 00:00:00", $quotes->first()->datetime);

        $quotes = $this->stock->quotes('01.01.2016', '02.01.2016', 'asc');

        $this->assertEquals("2016-01-01 00:00:00", $quotes->first()->datetime);
    }

    public function test_get_stock_quotes_from_a_specific_date()
    {
        $quotes = $this->stock->last('03.01.2016', 2);
        
        $this->assertCount(2, $quotes);

        $this->assertEquals("2016-01-03 00:00:00", $quotes->first()->datetime);
    }

}