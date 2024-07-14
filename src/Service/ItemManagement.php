<?php

namespace App\Service;

use App\Entity\FoodItem;

interface ItemManagement
{

    public function addItem(FoodItem $foodItem);

    public function getItems();

}
