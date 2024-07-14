<?php

namespace App\Service\unitConversion;


interface UnitValidation
{
    public function validate(string $unit);
}