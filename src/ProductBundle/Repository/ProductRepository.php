<?php

namespace ProductBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository{

    public function loadMoreProducts(int $limit,int $start){
        $qb=$this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from($this->_entityName,'p')
            ->where('p.validation=0')
            ->setFirstResult($start)
            ->setMaxResults($limit);
        $query=$qb->getQuery();

        return $result=$query->getResult();
    }

}