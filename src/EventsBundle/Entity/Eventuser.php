<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eventuser
 *
 * @ORM\Table(name="eventuser")
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
     * @ORM\JoinColumn(name="idU", referencedColumnName="id")
     */
    private $idu;

    /**
     * @var integer
     *
     * @ORM\Column(name="idevent", type="integer", nullable=false)
     */
    private $idevent;


}

