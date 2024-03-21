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
        $numbers = $this->getRandomIntArray();
        $sum = array_reduce($numbers, fn ($i,$c) => $i+$c, 0);
        $string = implode( ',', $numbers);

        $result = \NoiaKTas\StringCalculator\StringCalculator::compute($string);
        $this->assertEquals($sum, $result, sprintf("La somme devrait être de %d.", $sum));
    }

    public function testOnNewLineSeparatedStringShouldReturnTheSum()
    {
        $numbers = $this->getRandomIntArray();
        $sum = array_reduce($numbers, fn ($i,$c) => $i+$c, 0);
        $string = implode( "\n", $numbers);

        $result = \NoiaKTas\StringCalculator\StringCalculator::compute($string);
        $this->assertEquals($sum, $result, sprintf("La somme devrait être de %d.", $sum));
    }

    public function testOnRandomNewLineOrCommaSeparatedStringShouldReturnTheSum()
    {
        $numbers = $this->getRandomIntArray();
        $sum = array_reduce($numbers, fn ($i,$c) => $i+$c, 0);
        $string = array_reduce( $numbers,
            fn($number,$carry) => (
                sprintf("%s%s%s",$carry, (1===random_int(1,2)?",":"\n"),$number)),
            ''
        );

        $result = \NoiaKTas\StringCalculator\StringCalculator::compute($string);
        $this->assertEquals($sum, $result, sprintf("La somme devrait être de %d.", $sum));
    }

    public function testParametricSeparatorStringShouldReturnTheSum()
    {
        $numbers = $this->getRandomIntArray();
        $sum = array_reduce($numbers, fn ($i,$c) => $i+$c, 0);
        $separator = "'";
        $start = "\\\\'\n";
        $string = implode( $separator, $numbers);
        $string = $start . $string;


        $result = \NoiaKTas\StringCalculator\StringCalculator::compute($string);
        $this->assertEquals($sum, $result, sprintf("La somme devrait être de %d.", $sum));
    }

    public function testCallingAddWithNegativeNumberShouldThrowAnException()
    {
        $numbers = $this->getRandomIntArray();
        $numbers[] = -3;
        $string = implode(',',$numbers);

        $this->expectException(\Exception::class);
        \NoiaKTas\StringCalculator\StringCalculator::compute($string);

    }


    private function getRandomIntArray()
    {
        $n_times_dicing = random_int(5,10);
        $numbers = array();
        for ($i=0; $i<$n_times_dicing; $i++){
            $numbers[] = random_int(0,50);
        }

        return $numbers;
    }
}
