<?php

namespace NoiaKTas\StringCalculator;

class StringCalculator
{
    public static function compute(string $number): int
    {
        if (!$number){
            return 0;
        }

        $numbers = array_map(
            fn ($int_as_string) => intval($int_as_string),
            explode(",", $number));

        $result = array_reduce( $numbers, fn($n,$c) => $n+$c,0);
        return $result;
    }
}