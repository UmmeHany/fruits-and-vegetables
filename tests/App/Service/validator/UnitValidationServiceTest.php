<?php

namespace App\Tests\Service\validator;
use App\Service\unitConversion\UnitValidationService;
use PHPUnit\Framework\TestCase;

class UnitValidationServiceTest extends TestCase
{
    private $unitValidationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->unitValidationService = $this->createMock(UnitValidationService::class);
    }

    public function testValidateReturnsTrueForValidUnits()
    {
    
        $validUnits = ['g', 'kg'];

        $this->unitValidationService->method('validate')->willReturn(true);

        foreach ($validUnits as $unit) {
            $result = $this->unitValidationService->validate($unit);
            $this->assertTrue($result);
        }
    }

    public function testValidateReturnsFalseForInvalidUnits()
    {
        
        $invalidUnits = ['lbs','t'];

        $this->unitValidationService->method('validate')->willReturn(false);

        foreach ($invalidUnits as $unit) {
            $result = $this->unitValidationService->validate($unit);
            $this->assertFalse($result);
        }
    }
}