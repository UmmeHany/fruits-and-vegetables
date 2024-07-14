<?php

namespace App\Service\unitConversion;

use App\Entity\FoodItem;
use App\Service\CustomCollection;
use Doctrine\Common\Collections\ArrayCollection;

class UnitConversionToKiloGramService
{
    
    private CustomCollection $convertedDataCollection;

    private ConvertGramToKiloGramService $convertGramToKiloGramService;

    private UnitValidationService $unitValidationService;

    public function __construct(
        CustomCollection $itemCollection,
        ConvertGramToKiloGramService $convertGramToKiloGramService,
        UnitValidationService $unitValidationService) {
    
        $this->convertedDataCollection = $itemCollection;
        $this->convertGramToKiloGramService = $convertGramToKiloGramService;
        $this->unitValidationService = $unitValidationService;
    }

    public function getConvertedData(ArrayCollection $foodItems)
    {

        foreach ($foodItems as $foodItem) {

            if (!$this->unitValidationService->validate($foodItem->getUnit())) {

                //TODO log
                continue;
            }

            $this->convertedDataCollection->addItem($this->getConvertedItem($foodItem));
        }

        return $this->convertedDataCollection->getItems();
    }

    public function getConvertedItem(FoodItem $foodItem)
    {

        $weight = $foodItem->getQuantity();

        if (!$this->isKiloGram($foodItem->getUnit())) {
        
            $weight = $this->convertGramToKiloGramService->convert($foodItem->getQuantity());
        }

        $foodItem->setQuantity($weight);
        $foodItem->setUnit('kg');

        return $foodItem;
    }

    public function isKiloGram(string $unit)
    {
        return strtolower($unit) === 'kg';
    }

}
