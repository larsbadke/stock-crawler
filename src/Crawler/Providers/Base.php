<?php

namespace StockCrawler\Providers;

use StockCrawler\Generator;

class Base extends Provider{
    
   

    /**
     * @var Generator
     */
    private $generator;

    public function __construct(Generator $generator)
    {
        parent::__construct();
        
        $this->generator = $generator;
    }

    public static function price()
    {
        dd('sdsdf');
    }
 
    

}