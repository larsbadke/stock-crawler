<?php

namespace StockCrawler\Test;

use StockCrawler\Crawler;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    protected $stock;

    public function setUp()
    {
        $exampleStock = file_get_contents('exampleStock.json');

        $this->stock = json_decode($exampleStock, true);
    }

    /**
     * should be 2 - see exampleStock file
     */
    public function test_count_all_days_with_a_close_price_lower_than_105()
    {
        $condition = 'price() <= 105;';
        
        $crawl = new Crawler($this->stock, $condition);

        $crawl->from('01.01.2015')->to('01.01.2016');
        
        $results = $crawl->results();
        
        $this->assertCount(2, $results);
    }
    
    /**
     * should be 5 - see exampleStock file
     */
    public function test_count_all_days_with_a_lower_rsi_than_10()
    {
        $condition = 'rsi(14) <= 10;';

        $crawl = new Crawler($this->stock, $condition);

        $crawl->from('01.01.2016')->to('01.06.2016');

        $results = $crawl->results();
        
        $this->assertCount(5, $results);
    }

}