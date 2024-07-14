<?php

namespace App\Entity;

use App\Repository\FoodItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodItemRepository::class)]
class FoodItem
{
    
    private int $id;

    private string $name;

    private float $quantity;

    private string $type;

    private string $unit;

    public function getId(): int
    {
        return $this->id;
    }
 
    /**
     * Get the value of name
     */ 
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity() : float
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity(float $quantity) : self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType(string $type) : self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of unit
     */ 
    public function getUnit() : string
    {
        return $this->unit;
    }

    /**
     * Set the value of unit
     *
     * @return  self
     */ 
    public function setUnit(string $unit) : self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id) : self
    {
        $this->id = $id;

        return $this;
    }
}
