<?php


use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testOnEmptyStringItReturnsZero()
    {
        $result = \NoiaKTas\StringCalculator\StringCalculator::compute("");
        $this->assertEquals(0,$result, "Le résutat devrait être nul");
    }

    public function testOnOneNumberItReturnsThatNumber()
    {
        $result = \NoiaKTas\StringCalculator\StringCalculator::compute("5");
        $this->assertEquals(5,$result, "Le résultat devrait être 5.");
    }

    public function testOnTwoNumbersItReturnsTheSum()
    {
        $result = \NoiaKTas\StringCalculator\StringCalculator::compute("4,50");
        $this->assertEquals(54, $result, "Le résultat devrait être 54.");
    }

    public function testOnAnyNumberShouldReturnsTheSum()
    {
        $n_times_dicing = random_int(5,10);
        $numbers = array();
        for ($i=0; $i<$n_times_dicing; $i++){
            $numbers[] = random_int(0,50);
        }
        $sum = array_reduce($numbers, fn ($i,$c) => $i+$c, 0);
        $string = implode( ',', $numbers);

        $result = \NoiaKTas\StringCalculator\StringCalculator::compute($string);
        $this->assertEquals($sum, $result, sprintf("La somme devrait être de %d.", $sum));
    }

    public function testOnAnySeparatorWhichIsNotDigitShouldReturnTheSum()
    {

    }
}
