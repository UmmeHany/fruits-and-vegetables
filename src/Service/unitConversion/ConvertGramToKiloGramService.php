<?php

namespace App\Service\unitConversion;


class ConvertGramToKiloGramService implements ConvertUnit{

    public function convert(float $weight)
    {
        return $weight/1000.0;
    }
  
}