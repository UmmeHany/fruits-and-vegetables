<?php

namespace App\Service\vegetable\delete;

use App\Entity\FoodItem;
use App\Service\CustomCollection;
use App\Service\dataRetrival\FetchData;
use App\Service\dataRetrival\GetData;
use App\Service\fileOperation\SaveJson;
use App\Service\jsonOperation\JsonConverter;
use App\Service\jsonOperation\JsonParser;
use App\Service\ProcessFailedlItemsService;
use App\Service\Removal;
use App\Service\vegetable\VegetableValidationService;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

class VegetableRemovalService implements Removal
{
    private JsonParser $jsonParser;
    private FetchData $fetchData;

    private CustomCollection $fruits;

    private GetData $getData;

    private ArrayCollection $data;

    private ProcessFailedlItemsService $processFailedlItemsService;

    private FoodItem $foodItem;

    private JsonConverter $jsonConverter;

    private SaveJson $saveJson;

    private VegetableValidationService $vegetableValidationService;

    public function __construct(GetData $getData,
        JsonConverter $jsonConverter,
        SaveJson $saveJson,
        VegetableValidationService $vegetableValidationService
    ) {

        $this->getData = $getData;
        $this->data = $getData->get();
        $this->jsonConverter = $jsonConverter;
        $this->saveJson = $saveJson;
        $this->vegetableValidationService = $vegetableValidationService;
    }

    public function delete(int $id)
    {

        $foodItem = $this->getItem($id);
        if (!$foodItem || !$this->vegetableValidationService->validate($foodItem)) {
            return false;
        }

        try {
            $this->data->removeElement($foodItem);
            $json = $this->jsonConverter->convertToJson($this->data);
            $this->saveJson->save($json);
            return true;

        } catch (Exception $e) {
            return false;
        }

    }

    public function getItem(int $id)
    {
        return $this->data->filter(function ($item) use ($id) {
            return $item->getId() === $id;
        })->first();
    }

}
