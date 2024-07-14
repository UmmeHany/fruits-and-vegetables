<?php

namespace App\Service;

use App\Entity\FoodItem;
use Doctrine\Common\Collections\ArrayCollection;

class CustomCollection
{
    private ArrayCollection $itemCollection;

    public function __construct(ArrayCollection $itemCollection)
    {
        $this->itemCollection = $itemCollection;
    }

    public function setItem(ArrayCollection $itemCollection){
        $this->itemCollection = $itemCollection;
        return $this;
    }
   
    public function addItem(FoodItem $foodItem)
    {
        $this->itemCollection->add($foodItem);
    }

    public function getItems(): ArrayCollection
    {
        return $this->itemCollection;
    }

    public function getItemValues()
    {
        return $this->itemCollection->getValues();
    }

}


