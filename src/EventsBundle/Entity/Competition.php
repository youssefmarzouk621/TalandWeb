<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competition
 *
 * @ORM\Table(name="competition")
 * @ORM\Entity
 */
class Competition
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idcomp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcomp;

    /**
     * @var string
     *
     * @ORM\Column(name="namecomp", type="string", length=50, nullable=false)
     */
    private $namecomp;

    /**
     * @var string
     *
     * @ORM\Column(name="desccomp", type="string", length=9000, nullable=false)
     */
    private $desccomp;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrmaxspec", type="integer", nullable=false)
     */
    private $nbrmaxspec;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrmaxpar", type="integer", nullable=false)
     */
    private $nbrmaxpar;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=50, nullable=false)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="startingdate", type="string", length=50, nullable=false)
     */
    private $startingdate;

    /**
     * @var string
     *
     * @ORM\Column(name="endingdate", type="string", length=50, nullable=false)
     */
    private $endingdate;

    /**
     * @var float
     *
     * @ORM\Column(name="pricecomp", type="float", precision=10, scale=0, nullable=false)
     */
    private $pricecomp;

    /**
     * @var integer
     *
     * @ORM\Column(name="idcat", type="integer", nullable=false)
     */
    private $idcat;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrspec", type="integer", nullable=true)
     */
    private $nbrspec = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrparticipant", type="integer", nullable=false)
     */
    private $nbrparticipant = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;

    /**
     * @var integer
     *
     * @ORM\Column(name="idU", type="integer", nullable=false)
     */
    private $idu;


}

