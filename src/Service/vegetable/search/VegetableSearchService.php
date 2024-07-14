<?php

namespace App\Service\vegetable\search;

use App\Entity\FoodItem;
use Doctrine\Common\Collections\ArrayCollection;
use App\Service\SearchInterface;
use App\Service\dataRetrival\GetData;
use App\Service\vegetable\VegetableValidationService;

class VegetableSearchService implements SearchInterface
{
   

    private VegetableValidationService $vegetableValidationService;


    private ArrayCollection  $data;


    public function __construct( 
    VegetableValidationService $vegetableValidationService,
    GetData $getData)
    {
        $this->vegetableValidationService = $vegetableValidationService;
        $this->data = $getData->get(); 
       

    }

    public function search(int $id)
    {
        foreach($this->data->getIterator() as $foodItem){
           
            
            if($this->vegetableValidationService->validate($foodItem) && ($foodItem->getId() === $id) ){
                return $foodItem;
            }
        }

        return false;
        
    }

 

  
}