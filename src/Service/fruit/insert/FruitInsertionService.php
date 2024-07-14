<?php

namespace App\Service\fruit\insert;

use App\Entity\FoodItem;
use App\Service\CustomCollection;
use App\Service\dataRetrival\FetchData;
use App\Service\dataRetrival\GetData;
use App\Service\fileOperation\SaveJson;
use App\Service\fruit\FruitValidationService;
use App\Service\Insertion;
use App\Service\InsertionValidationService;
use App\Service\ItemManagement;
use App\Service\jsonOperation\JsonConverter;
use App\Service\jsonOperation\JsonParser;
use App\Service\unitConversion\UnitConversionToGramService;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Psr\Log\LoggerInterface;

class FruitInsertionService implements Insertion
{
    
    private InsertionValidationService $insertionValidationChecker;

    private FruitValidationService $fruitValidationService;

    private ArrayCollection $data;

    private ItemManagement $failedlItems;

    private JsonConverter $jsonConverter;

    private SaveJson $saveJson;

    private UnitConversionToGramService $unitConversionToGramService;

    private LoggerInterface $logger;

    public function __construct(InsertionValidationService $insertionValidationChecker,
        FruitValidationService $fruitValidationService,
        GetData $getData,
        ItemManagement $failedlItems,
        JsonConverter $jsonConverter,
        SaveJson $saveJson,
        UnitConversionToGramService $unitConversionToGramService,
        LoggerInterface $logger
    ) {
        $this->insertionValidationChecker = $insertionValidationChecker;
        $this->fruitValidationService = $fruitValidationService;
        $this->getData = $getData;
        $this->data = $getData->get();
        $this->jsonConverter = $jsonConverter;
        $this->saveJson = $saveJson;
        $this->unitConversionToGramService = $unitConversionToGramService;
        $this->failedlItems = $failedlItems;
        $this->logger = $logger;
    }

    public function add(FoodItem $foodItem)
    {

        if ($this->insertionValidationChecker->validate($foodItem) && $this->fruitValidationService->validate($foodItem)) {

            try {

                $item = $this->unitConversionToGramService->getConvertedItem($foodItem);
                $this->data->add($item);

            } catch (Exception $e) {
                $this->failedlItems->addItem($foodItem);
                $this->logger->error($e->getMessage());
            }

        } else {

            $this->logger->error('Insertion validation error');
            $this->failedlItems->addItem($foodItem);
        }

    }

    public function addItems(ArrayCollection $foodItems)
    {

        foreach ($foodItems as $foodItem) {
            $this->add($foodItem);
        }

        $json = $this->jsonConverter->convertToJson($this->data);

        $this->saveJson->save($json);

        return ['failedItems' => $this->failedlItems->getItems()->getItemValues()];
    }

}
