<?php

namespace App\Service\jsonOperation;

use Doctrine\Common\Collections\ArrayCollection;

interface JsonConverter
{
    
    public function convertToJson(ArrayCollection $items);
  
}