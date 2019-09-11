<?php


namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{

    public function getAllProducts()
    {
        return $this->createQueryBuilder('q')

            ->getQuery()
            ->getArrayResult();
    }

}