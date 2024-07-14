<?php

namespace App\Service;

use App\Entity\FoodItem;

interface FoodValidation
{
    
    public function validate(FoodItem $foodItem);

}