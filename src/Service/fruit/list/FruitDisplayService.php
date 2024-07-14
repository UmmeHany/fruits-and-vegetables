<?php

namespace App\Service\fruit\list;

use App\Service\CustomCollection;
use App\Service\dataRetrival\GetData;
use App\Service\Display;
use App\Service\fruit\FruitValidationService;

class FruitDisplayService implements Display
{

    private GetData $getData;

    private CustomCollection $fruits;

    private FruitValidationService $fruitValidationService;

    public function __construct(GetData $getData, CustomCollection $itemCollection, FruitValidationService $fruitValidationService)
    {
        $this->getData = $getData;
        $this->fruits = $itemCollection;
        $this->fruitValidationService = $fruitValidationService;
    }

    public function list()
    {

        $foodItems = $this->getData->get();

        foreach ($foodItems as $foodItem) {

            if ($this->fruitValidationService->validate($foodItem)) {

                $this->fruits->addItem($foodItem);
            }
        }

        return $this->fruits->getItems();
    }

}
