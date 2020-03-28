<?php

namespace ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="ProductBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getIdcategorymother()
    {
        return $this->idcategorymother;
    }

    /**
     * @param int $idcategorymother
     */
    public function setIdcategorymother($idcategorymother)
    {
        $this->idcategorymother = $idcategorymother;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="idCategoryMother", type="integer", nullable=true)
     */
    private $idcategorymother = 'NULL';

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


}

