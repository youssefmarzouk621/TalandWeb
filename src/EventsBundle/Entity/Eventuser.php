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
     * @var integer
     *
     * @ORM\Column(name="idU", type="integer", nullable=true)
     */
    private $idu;

    /**
     * @var integer
     *
     * @ORM\Column(name="idevent", type="integer", nullable=false)
     */
    private $idevent;


}

