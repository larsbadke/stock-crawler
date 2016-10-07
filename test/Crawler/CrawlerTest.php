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
     * should be 4 - see exampleStock file
     */
    public function test_crawl_all_quotes_with_a_close_price_smaller_than_85()
    {
        $condition = 'price() <= 85;';
        
        $crawl = new Crawler($this->stock, $condition);

        $crawl->from('01.01.2016')->to('01.01.2017');
        
        $results = $crawl->results();
        
        $this->assertCount(4, $results);
        
        $this->assertEquals(84.89, $results[0]->close);
    }


}