<?php

namespace StockCrawler;

class Conditions
{
    protected $conditions;

    protected $ignore = ["\n", "\r"];

    protected $index = 0;

    public function __construct($conditions)
    {
        $this->conditions = $conditions;

        $this->clean();

        $this->create();

    }

    public function clean()
    {
        $this->conditions = str_replace($this->ignore, '', $this->conditions);
    }

    public function create()
    {
        $this->conditions = array_filter(explode(';', $this->conditions));
    }

    public function get()
    {
        return $this->conditions;
    }
    
//    public function next()
//    {
//        if(!array_key_exists($this->index, $this->conditions)){
//
//            return null;
//        }
//
//        $condition = $this->conditions[$this->index];
//
//        $this->index++;
//
//        return (new Condition())->parse($condition);

//    }

}
