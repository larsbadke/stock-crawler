<?php

namespace StockCrawler;

class Compiler
{


    public function parse($condition, $quote)
    {
        $factory = Factory::create($quote);
        
        $string = '';

        $parts = $this->explode($condition);

        foreach ($parts as $part)
        {
            switch ($this->type($part)) {
                case "function":

                    $function = $this->getFunctionName($part);

                    $attitudes = $this->getFunctionAttitudes($part);
                    
                    $string .= $factory->$function($attitudes).' ';

                    break;
                case "operator":
                    
                    $string .= $part.' ';
                    
                    break;
                case "value":
                    
                    $string .= $part.' ';
                    
                    break;
            }
        }
        
        return $string;
    }

    public function explode($condition)
    {
        $pattern = '#[a-z]+\({1}.*\){1}#U';

        // find all functions and replace spaces
        $condition = preg_replace_callback($pattern, function($match){
            return str_replace(' ', '', $match[0]);
        },  $condition);

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
        if($this->isFunction($part)){
            return 'function';
        }

        if($this->isOperator($part)){
            return 'operator';
        }

        if($this->isValue($part)){
            return 'value';
        }

        return null;
    }

    public function isOperator($part)
    {
        $operators = ['<=', '=', '<='];

        foreach ($operators as $operator) {

            if(strpos($part, $operator)){

                return true;
            }
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
