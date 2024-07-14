<?php

namespace App\Tests\Service\json;

use App\Entity\FoodItem;
use App\Service\CustomCollection;
use App\Service\jsonOperation\JsonParserService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class JsonParserServiceTest extends TestCase
{

    private $jsonParserService;

    private CustomCollection $customCollection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customCollection = $this->createMock(CustomCollection::class);

        $this->jsonParserService = $this->createMock(JsonParserService::class);
    }

    public function testParseReturnsCustomCollection()
    {

        $json = '[{"id":1,"name":"mango"},{"id":2,"name":"apple"}]';

        $foodItems = new ArrayCollection([
            $this->createMock(FoodItem::class),
            $this->createMock(FoodItem::class),
        ]);

        $this->customCollection->method('setItem')->willReturn($this->customCollection);
        $customItems = $this->customCollection->setItem($foodItems);
        $this->jsonParserService->method('parse')->willReturn($this->customCollection);

        $result = $this->jsonParserService->parse($json);

        $this->assertEquals($customItems, $result);
    }

}
