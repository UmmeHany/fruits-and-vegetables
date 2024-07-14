<?php

namespace App\Service\fruit\delete;

use App\Entity\FoodItem;
use App\Service\dataRetrival\FetchData;
use App\Service\dataRetrival\GetData;
use App\Service\fileOperation\SaveJson;
use App\Service\fruit\FruitValidationService;
use App\Service\jsonOperation\JsonConverter;
use App\Service\jsonOperation\JsonParser;
use App\Service\ProcessFailedlItemsService;
use App\Service\Removal;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Psr\Log\LoggerInterface;

class FruitRemovalService implements Removal
{
    private JsonParser $jsonParser;
    private FetchData $fetchData;

    private GetData $getData;

    private ArrayCollection $data;

    private ProcessFailedlItemsService $processFailedlItemsService;

    private FoodItem $foodItem;

    private JsonConverter $jsonConverter;

    private SaveJson $saveJson;

    private FruitValidationService $fruitValidationService;

    private LoggerInterface $logger;

    public function __construct(GetData $getData,
        JsonConverter $jsonConverter,
        SaveJson $saveJson,
        FruitValidationService $fruitValidationService,
        LoggerInterface $logger
    ) {

        $this->getData = $getData;
        $this->data = $getData->get();
        $this->jsonConverter = $jsonConverter;
        $this->saveJson = $saveJson;
        $this->fruitValidationService = $fruitValidationService;
        $this->logger = $logger;
    }

    public function delete(int $id)
    {
        
        $foodItem = $this->getItem($id);
        if (!$foodItem || !$this->fruitValidationService->validate($foodItem)) {
            return false;
        }

        try {
            $this->data->removeElement($foodItem);

            $json = $this->jsonConverter->convertToJson($this->data);

            $this->saveJson->save($json);

            return true;

        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
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
