<?php

namespace App\Service\unitConversion;

use App\Entity\FoodItem;
use App\Service\CustomCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Log\LoggerInterface;

class UnitConversionToGramService
{

    private CustomCollection $convertedDataCollection;

    private ConvertKiloGramToGramService $convertKiloGramToGramService;

    private UnitValidationService $unitValidationService;

    private LoggerInterface $logger;

    public function __construct(
        CustomCollection $itemCollection,
        ConvertKiloGramToGramService $convertKiloGramToGramService,
        UnitValidationService $unitValidationService,
        LoggerInterface $logger) {

        $this->convertedDataCollection = $itemCollection;
        $this->convertKiloGramToGramService = $convertKiloGramToGramService;
        $this->unitValidationService = $unitValidationService;
        $this->logger = $logger;
    }

    public function getConvertedData(ArrayCollection $foodItems)
    {

        foreach ($foodItems as $foodItem) {

            if (!$this->unitValidationService->validate($foodItem->getUnit())) {

                $this->logger->error('unit conversion validation error for unit ' . $foodItem->getUnit());
                continue;
            }

            $this->convertedDataCollection->addItem($this->getConvertedItem($foodItem));
        }

        return $this->convertedDataCollection->getItems();
    }

    public function getConvertedItem(FoodItem $foodItem)
    {

        $weight = $foodItem->getQuantity();

        if (!$this->isGram($foodItem->getUnit())) {
            $weight = $this->convertKiloGramToGramService->convert($foodItem->getQuantity());
        }

        $foodItem->setQuantity($weight);
        $foodItem->setUnit('g');

        return $foodItem;
    }

    public function isGram(string $unit)
    {
        return strtolower($unit) === 'g';
    }

}
