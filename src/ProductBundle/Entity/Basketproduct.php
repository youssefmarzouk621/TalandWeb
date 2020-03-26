<?php

namespace ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Basketproduct
 *
 * @ORM\Table(name="basketproduct", indexes={@ORM\Index(name="basketId", columns={"basketId"}), @ORM\Index(name="productId", columns={"productId"})})
 * @ORM\Entity
 */
class Basketproduct
{
    /**
     * @var integer
     *
     * @ORM\Column(name="basketId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $basketid;

    /**
     * @var integer
     *
     * @ORM\Column(name="productId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $productid;


}

