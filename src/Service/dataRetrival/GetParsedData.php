<?php

namespace App\Service\dataRetrival;

use App\Service\CustomCollection;
use App\Service\jsonOperation\JsonParser;

class GetParsedData implements GetData
{
    private JsonParser $jsonParser;
    private FetchData $fetchData;
    
    private CustomCollection $fruits;

    public function __construct(JsonParser $jsonParser, FetchData $fetchData, CustomCollection $itemCollection)
    {
        $this->jsonParser = $jsonParser;
        $this->fruits = $itemCollection;
        $this->fetchData = $fetchData;
    }

    public function get(){

        $json = $this->fetchData->fetch();
        return $this->jsonParser->parse($json);
    }
  
}