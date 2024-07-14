<?php

namespace App\Tests\Service\vegetable;

use App\Entity\FoodItem;
use App\Service\CustomCollection;
use App\Service\dataRetrival\GetData;
use App\Service\vegetable\list\VegetableDisplayService;
use App\Service\vegetable\VegetableValidationService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class VegetableDisplayServiceTest extends TestCase
{
    private $getData;
    private $itemCollection;
    private $vegetableValidationService;
    private $vegetableDisplayService;

    protected function setUp(): void
    {
        $this->getData = $this->createMock(GetData::class);
        $this->itemCollection = $this->createMock(CustomCollection::class);
        $this->vegetableValidationService = $this->createMock(VegetableValidationService::class);
        
        $this->vegetableDisplayService = new VegetableDisplayService(
            $this->getData,
            $this->itemCollection,
            $this->vegetableValidationService
        );
    }

    public function testListReturnsValidatedItems()
    {
        $foodItem1 = $this->createMock(FoodItem::class);
        $foodItem2 = $this->createMock(FoodItem::class);

        $foodItems = new ArrayCollection([$foodItem1, $foodItem2]);

        $this->getData->method('get')->willReturn($foodItems);
        $this->vegetableValidationService->method('validate')
            ->willReturnMap([
                [$foodItem1, true],
                [$foodItem2, false]
            ]);

        $this->itemCollection->expects($this->once())
            ->method('addItem')
            ->with($foodItem1);

        $this->itemCollection->method('getItems')->willReturn(new ArrayCollection([$foodItem1]));

        $result = $this->vegetableDisplayService->list();

        $this->assertCount(1, $result);
        $this->assertSame($foodItem1, $result[0]);
    }

    public function testListReturnsEmptyWhenNoItemsValidated()
    {
        $foodItem1 = $this->createMock(FoodItem::class);
        $foodItem2 = $this->createMock(FoodItem::class);

        $foodItems = new ArrayCollection([$foodItem1, $foodItem2]);

        $this->getData->method('get')->willReturn($foodItems);
        $this->vegetableValidationService->method('validate')->willReturn(false);

        $this->itemCollection->expects($this->never())->method('addItem');
        $this->itemCollection->method('getItems')->willReturn(new ArrayCollection());

        $result = $this->vegetableDisplayService->list();

        $this->assertEmpty($result);
    }
}
