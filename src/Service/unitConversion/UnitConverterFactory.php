<?php

namespace App\Service\unitConversion;



class UnitConverterFactory implements GetConverterInterface
{
    
    private UnitConversionToGramService $unitConversionToGramService;

    private UnitConversionToKiloGramService $unitConversionToKiloGramService;
   
    public function __construct(UnitConversionToGramService $unitConversionToGramService,
                                UnitConversionToKiloGramService $unitConversionToKiloGramService)
    {

        $this->unitConversionToGramService = $unitConversionToGramService;
        $this->unitConversionToKiloGramService = $unitConversionToKiloGramService;
    }

    public function getConverter(string $unit){

        return match (strtolower($unit)) {
            'g' => $this->unitConversionToGramService,
            'kg' => $this->unitConversionToKiloGramService
          };
    }

}