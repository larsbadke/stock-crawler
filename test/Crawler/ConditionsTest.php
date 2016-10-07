<?php

namespace StockCrawler\Test;

use StockCrawler\Conditions;

class ConditionsTest extends \PHPUnit_Framework_TestCase
{
    public function test_multiple_conditions()
    {
        $example = "price() > 100 and RSI(14) >= 30;\n\r open() >= 99;";
        
        $conditions = new Conditions($example);
        
        $this->assertCount(2, $conditions->get());

        $this->assertEquals(2, $conditions->count());
    }
}