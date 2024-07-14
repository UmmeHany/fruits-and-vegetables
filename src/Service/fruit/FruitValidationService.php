<?php

namespace App\Service\fruit;

use App\Entity\FoodItem;
use App\Service\FoodValidation;

class FruitValidationService implements FoodValidation
{

    public function validate(FoodItem $foodItem)
    {
        return strtolower($foodItem->getType())==='fruit';        
    }

}