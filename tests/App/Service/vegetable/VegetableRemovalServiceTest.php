<?php


namespace App\Tests\Service\vegetable;

use App\Entity\FoodItem;
use App\Service\dataRetrival\GetData;
use App\Service\fileOperation\SaveJson;
use App\Service\jsonOperation\JsonConverter;
use App\Service\vegetable\delete\VegetableRemovalService;
use App\Service\vegetable\VegetableValidationService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class VegetableRemovalServiceTest extends TestCase
{
    private $getData;
    private $data;
    private $jsonConverter;
    private $saveJson;
    private $vegetableValidationService;
    private $logger;
    private $vegetableRemovalService;

    protected function setUp(): void
    {
        $this->getData = $this->createMock(GetData::class);
        $this->data = new ArrayCollection();
        $this->jsonConverter = $this->createMock(JsonConverter::class);
        $this->saveJson = $this->createMock(SaveJson::class);
        $this->vegetableValidationService = $this->createMock(VegetableValidationService::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->getData->method('get')->willReturn($this->data);

        $this->vegetableRemovalService = new VegetableRemovalService(
            $this->getData,
            $this->jsonConverter,
            $this->saveJson,
            $this->vegetableValidationService,
            $this->logger
        );
    }

    public function testDeleteValidFoodItem()
    {
        $foodItem = $this->createMock(FoodItem::class);
        $foodItem->method('getId')->willReturn(1);

        $this->data->add($foodItem);

        $this->vegetableValidationService->method('validate')->willReturn(true);
        $this->jsonConverter->method('convertToJson')->willReturn('json');

        $this->saveJson->expects($this->once())->method('save')->with('json');

        $result = $this->vegetableRemovalService->delete(1);

        $this->assertTrue($result);
        $this->assertCount(0, $this->data);
    }

    public function testDeleteInvalidFoodItem()
    {
        $foodItem = $this->createMock(FoodItem::class);
        $foodItem->method('getId')->willReturn(2);

        $this->data->add($foodItem);

        $this->vegetableValidationService->method('validate')->willReturn(false);

        $result = $this->vegetableRemovalService->delete(1);

        $this->assertFalse($result);
        $this->assertCount(1, $this->data);
    }

    public function testDeleteNonExistentFoodItem()
    {
        $result = $this->vegetableRemovalService->delete(1);

        $this->assertFalse($result);
        $this->assertCount(0, $this->data);
    }

}
