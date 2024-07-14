<?php

namespace App\Service\unitConversion;


class ConvertKiloGramToGramService implements ConvertUnit{
    
    public function convert(float $weight){

        return $weight*1000;
    }
  
}