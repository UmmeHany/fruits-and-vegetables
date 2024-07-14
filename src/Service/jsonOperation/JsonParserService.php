<?php

namespace App\Service\jsonOperation;

use App\Entity\FoodItem;

use Symfony\Component\Serializer\SerializerInterface;
use App\Factory\ArrayCollectionFactory;
use Exception;
use Psr\Log\LoggerInterface;

class JsonParserService implements JsonParser
{
    
    private $serializer;
    private $arrayCollectionFactory;
    private LoggerInterface $logger;

    public function __construct(SerializerInterface $serializer,ArrayCollectionFactory $arrayCollectionFactory,LoggerInterface $logger)
    {
        $this->serializer = $serializer;
        $this->arrayCollectionFactory = $arrayCollectionFactory;
        $this->logger= $logger;
    }

    public function parse(string $json)
    {
     
        try{
            $dataArray = $this->serializer->deserialize($json,'App\Entity\FoodItem[]', 'json');
        }catch(Exception $e){
            $this->logger->error($e->getMessage());
        }
       
        return $this->arrayCollectionFactory->createFrom($dataArray); 
    }
}