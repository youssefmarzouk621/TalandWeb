<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events
 *
 * @ORM\Table(name="events", indexes={@ORM\Index(name="IDX_5387574AA2D72265", columns={"idU"})})
 * @ORM\Entity
 */
class Events
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idEvent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevent;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=50, nullable=false)
     */
    private $location;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="price_event", type="float", precision=10, scale=0, nullable=false)
     */
    private $priceEvent;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat_event", type="integer", nullable=false)
     */
    private $etatEvent;

    /**
     * @var integer
     *
     * @ORM\Column(name="spec_max", type="integer", nullable=false)
     */
    private $specMax;

    /**
     * @var integer
     *
     * @ORM\Column(name="idU", type="integer", nullable=true)
     */
    private $idu;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrspectateurevent", type="integer", nullable=false)
     */
    private $nbrspectateurevent;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;


}

