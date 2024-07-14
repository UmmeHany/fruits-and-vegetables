<?php

namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;

interface Insertion
{

    public function addItems(ArrayCollection $foodItems);

}
