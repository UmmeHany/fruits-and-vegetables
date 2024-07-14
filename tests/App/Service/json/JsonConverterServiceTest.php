<?php

namespace App\Tests\Service\json;

use App\Service\jsonOperation\JsonConverterService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

class JsonConverterServiceTest extends TestCase
{
    private $serializerMock;
    private $jsonConverterService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializerMock = $this->createMock(SerializerInterface::class);

        $this->jsonConverterService = new JsonConverterService($this->serializerMock);
    }

    public function testConvertToJson()
    {

        $items = new ArrayCollection([
            ['id' => 1, 'name' => 'mango'],
            ['id' => 2, 'name' => 'apple'],
        ]);

        $expectedJson = '[{"id":1,"name":"mango"},{"id":2,"name":"apple"}]';

        $this->serializerMock->expects($this->once())
            ->method('serialize')
            ->with($items->toArray(), 'json')
            ->willReturn($expectedJson);

        $result = $this->jsonConverterService->convertToJson($items);

        $this->assertEquals($expectedJson, $result);
    }
}
