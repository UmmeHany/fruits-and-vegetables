<?php

namespace App\Service;

use App\Entity\FoodItem;
use App\Service\dataRetrival\GetData;
use App\Service\FoodValidation;
use Doctrine\Common\Collections\ArrayCollection;

class InsertionValidationService implements FoodValidation
{

    private ArrayCollection $data;

    public function __construct(GetData $getData)
    {
        $this->getData = $getData;
        $this->data = $getData->get();
    }

    public function setData(ArrayCollection $data)
    {
        $this->data = $data;
        return $this;
    }

    public function validate(FoodItem $foodItem)
    {
        foreach ($this->data->getIterator() as $item) {

            if ($item->getId() == $foodItem->getId()) {
                return false;
            }

        }

        return true;
    }

}
