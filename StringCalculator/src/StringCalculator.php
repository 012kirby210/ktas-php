<?php

namespace NoiaKTas\StringCalculator;

class StringCalculator
{
    
    const REG_PATTERN = "/^\\\\\\\\(.)\n/";
    
    public static function compute(string $string_of_numbers): int
    {
        if (!$string_of_numbers){
            return 0;
        }

        $separator = self::extractSeparator($string_of_numbers);

        $separator && $string_of_numbers = str_replace( $separator, "\n", self::removeSeparatorDefinition($separator, $string_of_numbers));
        $string_of_numbers = str_replace("\n", ',', $string_of_numbers);
        $numbers = self::getNumbers(",",$string_of_numbers);

        $result = array_reduce( $numbers, function($c,$n){
            if ($n<0){
                throw new \Exception("negatives not allowed");
            }
            return $n+$c;
        } ,0);
        return $result;
    }

    private static function removeSeparatorDefinition($separator, $string_of_numbers)
    {
        return preg_replace("/^\\\\\\\\".$separator."\n/", "", $string_of_numbers);
    }
    
    private static function extractSeparator($string_of_numbers)
    {
        $matches = [];
        preg_match(self::REG_PATTERN, $string_of_numbers, $matches);

        if ( isset($matches[1]) ){
            return $matches[1];
        }

        return null;

    }

    private static function getNumbers($separator, $string_of_numbers)
    {
        $numbers = array_map(
            fn ($int_as_string) => intval($int_as_string),
            explode($separator, $string_of_numbers));
        return $numbers;
    }

}