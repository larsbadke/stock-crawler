<?php

namespace StockCrawler\Test;

use StockCrawler\Helpers\ROC;

class ROCTest extends \PHPUnit_Framework_TestCase{
    
    protected $quotes;
    
    public function setUp()
    {
        $this->quotes = [
            [
                'open' => 100,
                'close' => 75,
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
                'close' => 100,
            ],
            [
                'open' => 200,
                'close' => 150,
            ],
        ];
    }
    
    public function test_calculation_of_close_quotes()
    {
        $roc4 = ROC::calculate($this->quotes, 4, 'close', 2);
        
        $this->assertEquals(-50, $roc4);
    }

    public function test_calculation_of_open_quotes()
    {
        $roc4 = ROC::calculate($this->quotes, 4, 'open', 2);

        $this->assertEquals(-50, $roc4);
    }

    public function test_calculation_with_lower_period()
    {
        $roc4 = ROC::calculate($this->quotes, 3, 'close', 2);

        $this->assertEquals(-25, $roc4);
    }
    
    /**
     * @expectedException Exception
     */
    public function test_calculation_with_not_enough_data()
    {
        ROC::calculate($this->quotes, 10, 'close', 2);
    }
}