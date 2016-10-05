<?php

namespace StockCrawler\Providers;


class Base extends Provider
{
    public function __construct($quote)
    {
        parent::__construct($quote);
    }

    public function price()
    {
        return $this->quote->close;
    }

    public function close()
    {
        return $this->quote->close;
    }

    public function open()
    {
        return $this->quote->open;
    }

    public function low()
    {
        return $this->quote->low;
    }

    public function high()
    {
        return $this->quote->high;
    }

    public function volume()
    {
        return $this->quote->volume;
    }
}