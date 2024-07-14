<?php

namespace App\Service\dataRetrival;

use Doctrine\Common\Collections\ArrayCollection;

class FetchDataService implements FetchData
{
    public function fetch(){
        return file_get_contents( __DIR__.'/../../../request.json');
    }
}