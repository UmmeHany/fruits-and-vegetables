<?php

namespace App\Service;

use App\Entity\FoodItem;

class FailedItemItemsService implements ItemManagement
{

    private CustomCollection $failedItems;

    private string $failedResponse = '';

    public function __construct(CustomCollection $failedItems)
    {

        $this->failedItems = $failedItems;
    }

    public function addItem(FoodItem $item)
    {
        $this->failedItems->addItem($item);
    }

    public function getItems()
    {
        return $this->failedItems;
    }

}
