<?php

namespace ProductBundle\Repository;



class ProductRepository extends \Doctrine\ORM\EntityRepository{

    public function loadMoreProducts($limit,$start){
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