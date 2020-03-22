<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competitionuser
 *
 * @ORM\Table(name="competitionuser", indexes={@ORM\Index(name="idcomp", columns={"idcomp"})})
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
     * @var integer
     *
     * @ORM\Column(name="idcomp", type="integer", nullable=false)
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


}

