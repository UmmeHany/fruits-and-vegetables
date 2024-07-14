<?php

namespace App\Service\vegetable\insert;

use App\Entity\FoodItem;
use App\Service\CustomCollection;
use App\Service\dataRetrival\FetchData;
use App\Service\dataRetrival\GetData;
use App\Service\FailedItemItemsService;
use App\Service\fileOperation\SaveJson;
use App\Service\Insertion;
use App\Service\InsertionValidationService;
use App\Service\ItemManagement;
use App\Service\jsonOperation\JsonConverter;
use App\Service\jsonOperation\JsonParser;
use App\Service\unitConversion\UnitConversionToGramService;
use App\Service\vegetable\VegetableValidationService;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class VegetableInsertionService implements Insertion
{
    

    private InsertionValidationService $insertionValidationChecker;

    private VegetableValidationService $vegetableValidationService;

    private ArrayCollection $data;

    private ItemManagement $failedlItems;

    private JsonConverter $jsonConverter;

    private SaveJson $saveJson;

    private UnitConversionToGramService $unitConversionToGramService;

    public function __construct(InsertionValidationService $insertionValidationChecker,
        VegetableValidationService $vegetableValidationService,
        GetData $getData,
        ItemManagement $failedlItems,
        JsonConverter $jsonConverter,
        SaveJson $saveJson,
        UnitConversionToGramService $unitConversionToGramService
    ) {
        $this->insertionValidationChecker = $insertionValidationChecker;
        $this->vegetableValidationService = $vegetableValidationService;
        $this->getData = $getData;
        $this->data = $getData->get();
        $this->jsonConverter = $jsonConverter;
        $this->saveJson = $saveJson;
        $this->unitConversionToGramService = $unitConversionToGramService;
        $this->failedlItems = $failedlItems;
    }

    public function add(FoodItem $foodItem)
    {

        if ($this->insertionValidationChecker->validate($foodItem) && $this->vegetableValidationService->validate($foodItem)) {

            try {

                $item = $this->unitConversionToGramService->getConvertedItem($foodItem);
                $this->data->add($item);

            } catch (Exception $e) {
                $this->failedlItems->addItem($foodItem);
            }

        } else {

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
