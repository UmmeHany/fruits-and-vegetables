<?php

namespace App\Service\fruit;

use App\Service\fruit\list\FruitDisplayService;
use App\Service\unitConversion\UnitConverterFactory;

class FruitUnitConversionService
{

    private FruitDisplayService $fruitsService;

    private UnitConverterFactory $unitConverterFactory;

    public function __construct(FruitDisplayService $fruitsService,UnitConverterFactory $unitConverterFactory) {

        $this->fruitsService = $fruitsService;
        $this->unitConverterFactory = $unitConverterFactory;
    }

    public function getConvertedData(string $unit)
    {
        $converter = $this->unitConverterFactory->getConverter($unit);
        $fruits = $this->fruitsService->list();
        return $converter->getConvertedData($fruits);  
    }

}
