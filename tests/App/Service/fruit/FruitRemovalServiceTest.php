<?php


namespace App\Tests\Service\fruit;

use App\Entity\FoodItem;
use App\Service\dataRetrival\GetData;
use App\Service\fileOperation\SaveJson;
use App\Service\fruit\FruitValidationService;
use App\Service\jsonOperation\JsonConverter;
use App\Service\fruit\delete\FruitRemovalService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class FruitRemovalServiceTest extends TestCase
{
    private $getData;
    private $data;
    private $jsonConverter;
    private $saveJson;
    private $fruitValidationService;
    private $logger;
    private $fruitRemovalService;

    protected function setUp(): void
    {
        $this->getData = $this->createMock(GetData::class);
        $this->data = new ArrayCollection();
        $this->jsonConverter = $this->createMock(JsonConverter::class);
        $this->saveJson = $this->createMock(SaveJson::class);
        $this->fruitValidationService = $this->createMock(FruitValidationService::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->getData->method('get')->willReturn($this->data);

        $this->fruitRemovalService = new FruitRemovalService(
            $this->getData,
            $this->jsonConverter,
            $this->saveJson,
            $this->fruitValidationService,
            $this->logger
        );
    }

    public function testDeleteValidFoodItem()
    {
        $foodItem = $this->createMock(FoodItem::class);
        $foodItem->method('getId')->willReturn(1);

        $this->data->add($foodItem);

        $this->fruitValidationService->method('validate')->willReturn(true);
        $this->jsonConverter->method('convertToJson')->willReturn('json');

        $this->saveJson->expects($this->once())->method('save')->with('json');

        $result = $this->fruitRemovalService->delete(1);

        $this->assertTrue($result);
        $this->assertCount(0, $this->data);
    }

    public function testDeleteInvalidFoodItem()
    {
        $foodItem = $this->createMock(FoodItem::class);
        $foodItem->method('getId')->willReturn(2);

        $this->data->add($foodItem);

        $this->fruitValidationService->method('validate')->willReturn(false);

        $result = $this->fruitRemovalService->delete(1);

        $this->assertFalse($result);
        $this->assertCount(1, $this->data);
    }

    public function testDeleteNonExistentFoodItem()
    {
        $result = $this->fruitRemovalService->delete(1);

        $this->assertFalse($result);
        $this->assertCount(0, $this->data);
    }

}
