<?php

namespace PostsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Viewer
 *
 * @ORM\Table(name="viewer")
 * @ORM\Entity(repositoryClass="PostsBundle\Repository\ViewerRepository")
 */
class Viewer
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idU", referencedColumnName="id")
     */
    private $idu;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPost", type="integer", nullable=false)
     */
    private $idpost;

    /**
     * @var string
     *
     * @ORM\Column(name="Adress", type="string", nullable=false)
     */
    private $address;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="operateur", type="string")
     */
    private $operateur;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string")
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string")
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string")
     */
    private $ville;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Viewer
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
     * @return string
     */
    public function getOperateur()
    {
        return $this->operateur;
    }

    /**
     * @param string $operateur
     */
    public function setOperateur($operateur)
    {
        $this->operateur = $operateur;
    }

    /**
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return mixed
     */
    public function getIdu()
    {
        return $this->idu;
    }

    /**
     * @param mixed $idu
     */
    public function setIdu($idu)
    {
        $this->idu = $idu;
    }

    /**
     * @return int
     */
    public function getIdpost()
    {
        return $this->idpost;
    }

    /**
     * @param int $idpost
     */
    public function setIdpost($idpost)
    {
        $this->idpost = $idpost;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }




}

