<?php

namespace App\Tests\Service\fruit;

use App\Entity\FoodItem;
use App\Service\dataRetrival\GetData;
use App\Service\fileOperation\SaveJson;
use App\Service\fruit\FruitValidationService;
use App\Service\InsertionValidationService;
use App\Service\ItemManagement;
use App\Service\jsonOperation\JsonConverter;
use App\Service\unitConversion\UnitConversionToGramService;
use App\Service\fruit\insert\FruitInsertionService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class FruitInsertionServiceTest extends TestCase
{
    private $insertionValidationChecker;
    private $fruitValidationService;
    private $getData;
    private $data;
    private $failedItems;
    private $jsonConverter;
    private $saveJson;
    private $unitConversionToGramService;
    private $logger;
    private $fruitInsertionService;

    protected function setUp(): void
    {
        $this->insertionValidationChecker = $this->createMock(InsertionValidationService::class);
        $this->fruitValidationService = $this->createMock(FruitValidationService::class);
        $this->getData = $this->createMock(GetData::class);
        $this->data = new ArrayCollection();
        $this->failedItems = $this->createMock(ItemManagement::class);
        $this->jsonConverter = $this->createMock(JsonConverter::class);
        $this->saveJson = $this->createMock(SaveJson::class);
        $this->unitConversionToGramService = $this->createMock(UnitConversionToGramService::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->getData->method('get')->willReturn($this->data);

        $this->fruitInsertionService = new FruitInsertionService(
            $this->insertionValidationChecker,
            $this->fruitValidationService,
            $this->getData,
            $this->failedItems,
            $this->jsonConverter,
            $this->saveJson,
            $this->unitConversionToGramService,
            $this->logger
        );
    }

    public function testAddValidFoodItem()
    {
        $foodItem = $this->createMock(FoodItem::class);

        $this->insertionValidationChecker->method('validate')->willReturn(true);
        $this->fruitValidationService->method('validate')->willReturn(true);
        $this->unitConversionToGramService->method('getConvertedItem')->willReturn($foodItem);

        $this->fruitInsertionService->add($foodItem);

        $this->assertCount(1, $this->data);
        $this->assertTrue($this->data->contains($foodItem));
    }

    public function testAddInvalidFoodItem()
    {
        $foodItem = $this->createMock(FoodItem::class);

        $this->insertionValidationChecker->method('validate')->willReturn(false);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Insertion validation error');

        $this->failedItems->expects($this->once())
                          ->method('addItem')
                          ->with($foodItem);

        $this->fruitInsertionService->add($foodItem);

        $this->assertCount(0, $this->data);
    }

   
}
