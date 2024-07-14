<?php

namespace App\Service\vegetable;

use App\Entity\FoodItem;
use App\Service\FoodValidation;

class VegetableValidationService implements FoodValidation
{
    
    public function validate(FoodItem $foodItem)
    {
        return strtolower($foodItem->getType())==='vegetable';        
    }

}