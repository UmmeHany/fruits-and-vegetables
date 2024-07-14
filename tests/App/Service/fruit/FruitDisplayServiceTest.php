<?php

namespace App\Tests\Service\fruit\list;

use App\Entity\FoodItem;
use App\Service\CustomCollection;
use App\Service\dataRetrival\GetData;
use App\Service\fruit\FruitValidationService;
use App\Service\fruit\list\FruitDisplayService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class FruitDisplayServiceTest extends TestCase
{
    private $getData;
    private $itemCollection;
    private $fruitValidationService;
    private $fruitDisplayService;

    protected function setUp(): void
    {
        $this->getData = $this->createMock(GetData::class);
        $this->itemCollection = $this->createMock(CustomCollection::class);
        $this->fruitValidationService = $this->createMock(FruitValidationService::class);

        $this->fruitDisplayService = new FruitDisplayService(
            $this->getData,
            $this->itemCollection,
            $this->fruitValidationService
        );
    }

    public function testListReturnsValidatedItems()
    {
        $foodItem1 = $this->createMock(FoodItem::class);
        $foodItem2 = $this->createMock(FoodItem::class);

        $foodItems = new ArrayCollection([$foodItem1, $foodItem2]);

        $this->getData->method('get')->willReturn($foodItems);
        $this->fruitValidationService->method('validate')
            ->willReturnMap([
                [$foodItem1, true],
                [$foodItem2, false]
            ]);

        $this->itemCollection->expects($this->once())
            ->method('addItem')
            ->with($foodItem1);

        $this->itemCollection->method('getItems')->willReturn(new ArrayCollection([$foodItem1]));

        $result = $this->fruitDisplayService->list();

        $this->assertCount(1, $result);
        $this->assertSame($foodItem1, $result[0]);
    }

    public function testListReturnsEmptyWhenNoItemsValidated()
    {
        $foodItem1 = $this->createMock(FoodItem::class);
        $foodItem2 = $this->createMock(FoodItem::class);

        $foodItems = new ArrayCollection([$foodItem1, $foodItem2]);

        $this->getData->method('get')->willReturn($foodItems);
        $this->fruitValidationService->method('validate')->willReturn(false);

        $this->itemCollection->expects($this->never())->method('addItem');
        $this->itemCollection->method('getItems')->willReturn(new ArrayCollection());

        $result = $this->fruitDisplayService->list();

        $this->assertEmpty($result);
    }
}
