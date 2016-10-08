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
     * ------------------------------------
     * 1. - 24.08.2015
     * 2. - 25.08.2015
     */
    public function test_count_all_days_with_a_close_price_lower_than_105()
    {
        $condition = 'price() <= 105;';
        
        $crawl = new Crawler($this->stock, $condition);

        $crawl->from('01.01.2015')->to('01.01.2016');
        
        $results = $crawl->results();
        
        $this->assertCount(2, $results);

        $this->assertEquals("2015-08-24 00:00:00", $results[0]->datetime);

        $this->assertEquals("2015-08-25 00:00:00", $results[1]->datetime);
    }
    
    /**
     * should be 5 - see exampleStock file
     * ------------------------------------
     * 1. - 02.05.2016
     * 2. - 03.05.2016
     * 3. - 04.05.2016
     * 4. - 05.05.2016
     * 5. - 06.05.2016
     * 
     */
    public function test_count_all_days_with_a_lower_rsi_than_10()
    {
        $condition = 'rsi(14) <= 10;';

        $crawl = new Crawler($this->stock, $condition);

        $crawl->from('01.01.2016')->to('01.06.2016');

        $results = $crawl->results();
        
        $this->assertCount(5, $results);
        
        $this->assertEquals("2016-05-02 00:00:00", $results[0]->datetime);

        $this->assertEquals("2016-05-03 00:00:00", $results[1]->datetime);

        $this->assertEquals("2016-05-04 00:00:00", $results[2]->datetime);

        $this->assertEquals("2016-05-05 00:00:00", $results[3]->datetime);

        $this->assertEquals("2016-05-06 00:00:00", $results[4]->datetime);
    }

    /**
     * should be 1 - see exampleStock file
     * ------------------------------------
     * 1. - 28.04.2016
     */
    public function test_count_all_days_with_a_lower_rate_of_change_than_minus_15()
    {
        $condition = 'roc(10) <= -15;';

        $crawl = new Crawler($this->stock, $condition);

        $crawl->from('01.01.2016')->to('01.06.2016');

        $results = $crawl->results();

        $this->assertCount(1, $results);

        $this->assertEquals("2016-04-28 00:00:00", $results[0]->datetime);
    }

    /**
     * should be 2 - see exampleStock file
     * ------------------------------------
     * 1. - 24.08.2015
     * 2. - 25.08.2015
     */
    public function test_smaller_than_synonyms()
    {
        $conditions = [
            'price() < 105;',
            'price() smaller than 105;',
            'price() smaller 105;',
        ];
        
        foreach ($conditions as $condition){
            
            $crawl = new Crawler($this->stock, $condition);

            $crawl->from('01.01.2015')->to('01.01.2016');

            $results = $crawl->results();

            $this->assertCount(2, $results);
        }
    }

    /**
     * should be 2 - see exampleStock file
     * ------------------------------------
     * 1. - 24.08.2015
     * 2. - 25.08.2015
     */
    public function test_smaller_or_same_synonyms()
    {
        $conditions = [
            'price() <= 105;',
            'price() smaller or same 105;',
        ];

        foreach ($conditions as $condition){

            $crawl = new Crawler($this->stock, $condition);

            $crawl->from('01.01.2015')->to('01.01.2016');

            $results = $crawl->results();

            $this->assertCount(2, $results);
        }
    }

}