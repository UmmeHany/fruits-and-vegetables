<?php

namespace App\Service\unitConversion;


class UnitValidationService implements UnitValidation
{
    
    public function validate(string $unit)
    {
        return strtolower($unit) === 'g'|| strtolower($unit) === 'kg';        
    }
   
}