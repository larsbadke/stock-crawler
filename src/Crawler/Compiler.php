<?php

namespace StockCrawler;

class Compiler
{
    protected $stock;

    public function __construct($stock, $quote)
    {
        $this->stock = $stock;

        $this->factory = Factory::create($stock, $quote);
    }

    public function parse($condition)
    {
        $complied = [];

        $terms = $this->explode($condition);

        foreach ($terms as $index => $term) {
            $string = '';

            switch ($this->type($term)) {
                case "function":
                    $function = $this->getFunctionName($term);
                    $attitudes = $this->getFunctionAttitudes($term);

                    $string = call_user_func_array([$this->factory, $function], $attitudes);
                    break;
                case "operator":
                    $string = $term;
                    break;
                case "value":
                    $string = $term;
                    break;
            }

            $complied[$index] = $string;
        }

        return implode(' ', $complied);
    }

    protected function checkErrors($condition)
    {
//        var_dump($condition);
//
//
//        var_dump(strpos('error', $condition));
//
//        if(strpos('error', $condition)){
//
//        }

        return false;
    }

    public function isTrue($complied)
    {
        $result = false;

        $condition = 'return ' . $complied . ';';

        if(!$this->checkErrors($condition)){

            $result = eval($condition);
        }

        return $result;
    }

    public function explode($condition)
    {
        $pattern = '#[a-z]+\({1}.*\){1}#U';

        // find all functions and replace spaces
        $condition = preg_replace_callback($pattern, function ($match) {
            return str_replace(' ', '', $match[0]);
        }, $condition);

        return explode(' ', $condition);
    }

    public function getFunctionName($part)
    {
        $pattern = '#[a-z]+#';

        preg_match($pattern, $part, $match);

        return $match[0];
    }

    public function getFunctionAttitudes($part)
    {
        $pattern = '#\({1}.*\){1}$#';

        preg_match($pattern, $part, $match);

        $replaces = ['(', ')'];

        $attitudes = str_replace($replaces, '', $match);

        return explode(',', $attitudes[0]);
    }

    public function type($part)
    {
        if ($this->isFunction($part)) {
            return 'function';
        }

        if ($this->isOperator($part)) {
            return 'operator';
        }

        if ($this->isValue($part)) {
            return 'value';
        }

        return null;
    }

    public function isOperator($operator)
    {
        $operators = ['<=', '=', '>=', 'and', '&&'];

        if (in_array($operator, $operators)) {

            return true;
        }

        return false;
    }

    public function isFunction($part)
    {
        $pattern = '#[a-z]+\({1}.*\){1}$#';

        return (preg_match($pattern, $part)) ? true : false;
    }

    public function isValue($part)
    {
        return is_numeric($part);
    }

}
