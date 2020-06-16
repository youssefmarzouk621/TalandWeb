<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favoris
 *
 * @ORM\Table(name="favoris")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\FavorisRepository")
 */
class Favoris
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Sujet")
     * @ORM\JoinColumn(name="id_f", referencedColumnName="id_f")
     */
    private $idF;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionf", type="text")
     */
    private $descriptionf;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrejaime", type="integer")
     */
    private $nbrejaime;

    /**
     * @var int
     *
     * @ORM\Column(name="strike", type="integer")
     */
    private $strike;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdF()
    {
        return $this->idF;
    }

    /**
     * @param mixed $idF
     */
    public function setIdF($idF)
    {
        $this->idF = $idF;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }







    /**
     * Set descriptionf
     *
     * @param string $descriptionf
     *
     * @return Favoris
     */
    public function setDescriptionf($descriptionf)
    {
        $this->descriptionf = $descriptionf;

        return $this;
    }

    /**
     * Get descriptionf
     *
     * @return string
     */
    public function getDescriptionf()
    {
        return $this->descriptionf;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Favoris
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nbrejaime
     *
     * @param integer $nbrejaime
     *
     * @return Favoris
     */
    public function setNbrejaime($nbrejaime)
    {
        $this->nbrejaime = $nbrejaime;

        return $this;
    }

    /**
     * Get nbrejaime
     *
     * @return int
     */
    public function getNbrejaime()
    {
        return $this->nbrejaime;
    }

    /**
     * Set strike
     *
     * @param integer $strike
     *
     * @return Favoris
     */
    public function setStrike($strike)
    {
        $this->strike = $strike;

        return $this;
    }

    /**
     * Get strike
     *
     * @return int
     */
    public function getStrike()
    {
        return $this->strike;
    }
}

