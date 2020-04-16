<?php

namespace CalendarZiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rules
 *
 * @ORM\Table(name="rules")
 * @ORM\Entity
 */
class Rules
{
    /**
     * @var string
     *
     * @ORM\Column(name="EventDescription", type="string", length=200, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $eventdescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="TermID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $termid;

    /**
     * @var integer
     *
     * @ORM\Column(name="DaysFromStart", type="integer", nullable=true)
     */
    private $daysfromstart;


}

