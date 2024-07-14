<?php

namespace App\Tests\Service\unitConversion;

use App\Service\unitConversion\ConvertKiloGramToGramService;
use PHPUnit\Framework\TestCase;

class ConvertKiloGramToGramServiceTest extends TestCase
{
    private ConvertKiloGramToGramService $convertKiloGramToGramService;

    protected function setUp(): void
    {
        $this->convertKiloGramToGramService = new ConvertKiloGramToGramService();
    }

    public function testConvert()
    {
        $weightInKilograms = 1;
        $expectedWeightInGrams = 1000;

        $result = $this->convertKiloGramToGramService->convert($weightInKilograms);

        $this->assertEquals($expectedWeightInGrams, $result);
    }

    public function testConvertWithDecimal()
    {
        $weightInKilograms = 1.5;
        $expectedWeightInGrams = 1500;

        $result = $this->convertKiloGramToGramService->convert($weightInKilograms);

        $this->assertEquals($expectedWeightInGrams, $result);
    }

    public function testConvertWithZero()
    {
        $weightInKilograms = 0;
        $expectedWeightInGrams = 0;

        $result = $this->convertKiloGramToGramService->convert($weightInKilograms);

        $this->assertEquals($expectedWeightInGrams, $result);
    }
}
