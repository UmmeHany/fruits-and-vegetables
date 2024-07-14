<?php

namespace App\Service\jsonOperation;

use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\Common\Collections\ArrayCollection;

class JsonConverterService implements JsonConverter
{
    private string $json = '';

    private $serializer;
   

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function convertToJson(ArrayCollection $items)
    {     
        return $this->serializer->serialize($items->toArray(), 'json');
    }
}