<?php

namespace App\Service\vegetable;

use App\Service\unitConversion\UnitConverterFactory;
use App\Service\vegetable\list\VegetableDisplayService;

class VegetableUnitConversionService
{
   
    private VegetableDisplayService $vegetablesService;

    private UnitConverterFactory $unitConverterFactory;

    public function __construct(VegetableDisplayService $vegetablesService,UnitConverterFactory $unitConverterFactory) {

        $this->vegetablesService = $vegetablesService;
        $this->unitConverterFactory = $unitConverterFactory;
    }

    public function getConvertedData(string $unit)
    {
        $converter = $this->unitConverterFactory->getConverter($unit);
        $vegetables = $this->vegetablesService->list();
        return $converter->getConvertedData($vegetables);  
    }

}
