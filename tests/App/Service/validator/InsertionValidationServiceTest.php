<?php


namespace App\Tests\App\Service\validator;

use App\Entity\FoodItem;
use App\Service\dataRetrival\GetData;
use App\Service\InsertionValidationService;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;


class InsertionValidationServiceTest extends TestCase
{

    private $getDataMock;
    private $dataCollection;
    private InsertionValidationService $insertionValidationService;

    protected function setUp(): void
    {
        parent::setUp();


        $this->getDataMock = $this->createMock(GetData::class);
        $this->insertionValidationService = $this->createMock(InsertionValidationService::class);

       
        $this->dataCollection = new ArrayCollection([
            $this->createMock(FoodItem::class), 
            $this->createMock(FoodItem::class),
            $this->createMock(FoodItem::class),
        ]);

       
        $this->getDataMock->expects($this->any())
            ->method('get')
            ->willReturn($this->dataCollection);
    }

    public function testValidateReturnsTrueForNewFoodItem()
    {
        
        $foodItem = $this->createMock(FoodItem::class);

        $this->insertionValidationService->setData($this->dataCollection);
        $this->insertionValidationService->method('validate')->willReturn(true);

        $result = $this->insertionValidationService->validate($foodItem);


        $this->assertTrue($result);
    }

    public function testValidateReturnsFalseForExistingFoodItem()
    {
        
      
        $foodItem = new FoodItem($this->dataCollection->first(), 'Existing Food Item');

        
        $this->insertionValidationService->setData($this->dataCollection);

        $this->insertionValidationService->method('validate')->willReturn(false);

        $result = $this->insertionValidationService->validate($foodItem);

        $this->assertFalse($result);
    }
}
