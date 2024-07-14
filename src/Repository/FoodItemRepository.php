<?php

namespace App\Repository;

use App\Entity\FoodItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FoodItem>
 *
 * @method FoodItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method FoodItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method FoodItem[]    findAll()
 * @method FoodItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FoodItem::class);
    }


public function getFruits(){

}


}
