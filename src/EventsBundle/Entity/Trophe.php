<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trophe
 *
 * @ORM\Table(name="trophe")
 * @ORM\Entity
 */
class Trophe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idtrophe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtrophe;

    /**
     * @var integer
     *
     * @ORM\Column(name="idcomp", type="integer", nullable=false)
     */
    private $idcomp;

    /**
     * @var integer
     *
     * @ORM\Column(name="idu", type="integer", nullable=false)
     */
    private $idu;


}

