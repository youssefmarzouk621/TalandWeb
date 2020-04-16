<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competitionuser
 *
 * @ORM\Table(name="competitionuser", indexes={@ORM\Index(name="idcomp", columns={"idcomp"}), @ORM\Index(name="IDX_58EEEFBB99B902AD", columns={"idu"})})
 * @ORM\Entity
 */
class Competitionuser
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
     * @ORM\ManyToOne(targetEntity="EventsBundle\Entity\Competition")
     * @ORM\JoinColumn(name="idcomp", referencedColumnName="idcomp")
     */
    private $idcomp;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idu", referencedColumnName="id")
     */
    private $idu;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @return mixed
     */
    public function getIdcomp()
    {
        return $this->idcomp;
    }

    /**
     * @param mixed $idcomp
     */
    public function setIdcomp($idcomp)
    {
        $this->idcomp = $idcomp;
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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}

