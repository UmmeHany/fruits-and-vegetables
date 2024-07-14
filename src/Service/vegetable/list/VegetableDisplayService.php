<?php

namespace App\Service\vegetable\list;

use App\Service\CustomCollection;
use App\Service\dataRetrival\GetData;
use App\Service\Display;
use App\Service\vegetable\VegetableValidationService;

class VegetableDisplayService implements Display
{

    private GetData $getData;

    private CustomCollection $vegetable;

    private VegetableValidationService $vegetableValidationService;

    public function __construct(GetData $getData, CustomCollection $itemCollection, VegetableValidationService $vegetableValidationService)
    {
        $this->getData = $getData;
        $this->vegetable = $itemCollection;
        $this->vegetableValidationService = $vegetableValidationService;

    }

    public function list()
    {

        $foodItems = $this->getData->get();

        foreach ($foodItems as $foodItem) {

            if ($this->vegetableValidationService->validate($foodItem)) {

                $this->vegetable->addItem($foodItem);

            }

        }

        return $this->vegetable->getItems();

    }

}
