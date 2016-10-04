<?php

namespace StockCrawler;

class Condition
{

    public static function parse($condition)
    {
        var_dump($condition);

        $array = [];



        $parts = explode(' ', $condition);


        //todo smart explode of $condition
        dd($parts);
        
        foreach ($parts as $part)
        {


            switch (static::type($part)) {
                case "function":
                    echo "function<br>";


                    $function = static::getFunctionName($part);

                    $attitudes = static::getFunctionAttitudes($part);

                    break;
                case "operator":
                    echo "operator<br>";
                    break;
                case "value":
                    echo "value<br>";
                    break;
            }

        }

        dd($parts);



        return $condition;
    }

    public static function getFunctionName($part)
    {
        $pattern = '#[a-z]+#';

        preg_match($pattern, $part, $match);

        return $match;
    }

    public static function getFunctionAttitudes($part)
    {
        $pattern = '#\({1}.*\){1}$#';

        preg_match($pattern, $part, $match);

        dd($match);

        $replaces = ['(', ')'];

        $attitudes = str_replace($replaces, '', $match);

        dd($attitudes);

        return $attitudes;
    }

    public static function type($part)
    {
        if(static::isFunction($part)){
            return 'function';
        }

        if(static::isOperator($part)){
            return 'operator';
        }

        if(static::isValue($part)){
            return 'value';
        }

        return null;
    }

    public static function isOperator($part)
    {
        $operators = ['<=', '=', '<='];

        foreach ($operators as $operator) {

            if(strpos($part, $operator)){

                return true;
            }
        }

        return false;
    }

    public static function isFunction($part)
    {
        $pattern = '#[a-z]+\({1}.*\){1}$#';

        return (preg_match($pattern, $part)) ? true : false;
    }

    public static function isValue($part)
    {
        return is_numeric($part);
    }

}
