<?php

namespace App\Service\fruit\search;

use App\Entity\FoodItem;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use App\Service\SearchInterface;
use App\Service\dataRetrival\GetData;
use App\Service\fruit\FruitValidationService;

class FruitSearchService implements SearchInterface
{
   
    private FruitValidationService $fruitValidationService;

    private ArrayCollection  $data;

    public function __construct( FruitValidationService $fruitValidationService, GetData $getData)
    {
        $this->fruitValidationService = $fruitValidationService;
        $this->data = $getData->get(); 
    }

    public function search(int $id)
    {
        foreach($this->data->getIterator() as $foodItem){
           
            if($this->fruitValidationService->validate($foodItem) && ($foodItem->getId() === $id) ){
                return $foodItem;
            }
        }

        return false;
    }

}