<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eventuser
 *
 * @ORM\Table(name="eventuser", indexes={@ORM\Index(name="IDX_D1370A60A2D72265", columns={"idU"})})
 * @ORM\Entity
 */
class Eventuser
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idu", referencedColumnName="id")
     */
    private $idu;

    /**
     * @var integer
     *
     * @ORM\Column(name="idevent", type="integer", nullable=false)
     */
    private $idevent;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getIdevent()
    {
        return $this->idevent;
    }

    /**
     * @param int $idevent
     */
    public function setIdevent($idevent)
    {
        $this->idevent = $idevent;
    }


}

