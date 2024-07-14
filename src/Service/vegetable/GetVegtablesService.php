<?php
namespace App\Service\vegetable;

use App\Service\CustomCollection;
use App\Service\dataRetrival\GetData;
use App\Service\vegetable\VegetableValidationService;

class GetVegtablesService
{
    private GetData $getData;

    private CustomCollection $vegetables;

    private VegetableValidationService $vegetableValidationService;

    public function __construct(GetData $getData,
        CustomCollection $itemCollection,
        VegetableValidationService $vegetableValidationService
        ) {
        $this->getData = $getData;
        $this->vegetables = $itemCollection;
        $this->vegetableValidationService = $vegetableValidationService;

    }

    public function getData(){

        $foodItems = $this->getData->get();

        foreach($foodItems as $item){

            if($this->vegetableValidationService->validate($item)){
                $this->vegetables->addItem($item);
            }

        }

        return $this->vegetables;

    }

   
}


