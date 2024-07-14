<?php

namespace App\Service\unitConversion;

interface GetConverterInterface
{
    public function getConverter(string $unit);
}