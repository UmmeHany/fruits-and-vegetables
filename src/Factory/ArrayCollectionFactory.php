<?php
namespace App\Factory;

use Doctrine\Common\Collections\ArrayCollection;

class ArrayCollectionFactory
{
    public function create(): ArrayCollection
    {
        return new ArrayCollection();
    }
    public function createFrom(array $elements = []): ArrayCollection
    {
        return new ArrayCollection($elements);
    }
}