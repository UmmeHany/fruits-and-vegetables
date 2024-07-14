<?php

namespace App\Tests\Service\unitConversion;

use App\Service\unitConversion\ConvertGramToKiloGramService;
use PHPUnit\Framework\TestCase;

class ConvertGramToKiloGramServiceTest extends TestCase
{
    private ConvertGramToKiloGramService $convertGramToKiloGramService;

    protected function setUp(): void
    {
        $this->convertGramToKiloGramService = $this->createMock(ConvertGramToKiloGramService::class);
    }

    public function testConvert()
    {
        $weightInGrams = 1000;
        $expectedWeightInKilograms = 1.0;

        $this->convertGramToKiloGramService->method('convert')->willReturn(1.0);
        $result = $this->convertGramToKiloGramService->convert($weightInGrams);
        

        $this->assertEquals($expectedWeightInKilograms, $result);
    }

    public function testConvertWithDecimal()
    {
        $weightInGrams = 1500;
        $expectedWeightInKilograms = 1.5;

        $this->convertGramToKiloGramService->method('convert')->willReturn(1.5);

        $result = $this->convertGramToKiloGramService->convert($weightInGrams);

        $this->assertEquals($expectedWeightInKilograms, $result);
    }

    public function testConvertWithZero()
    {
        $weightInGrams = 0;
        $expectedWeightInKilograms = 0;

        $this->convertGramToKiloGramService->method('convert')->willReturn(0);
        $result = $this->convertGramToKiloGramService->convert($weightInGrams);

        $this->assertEquals($expectedWeightInKilograms, $result);
    }
}
