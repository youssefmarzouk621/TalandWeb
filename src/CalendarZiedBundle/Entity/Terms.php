<?php

namespace CalendarZiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Terms
 *
 * @ORM\Table(name="terms")
 * @ORM\Entity
 */
class Terms
{
    /**
     * @var integer
     *
     * @ORM\Column(name="TermID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $termid;

    /**
     * @var string
     *
     * @ORM\Column(name="TermName", type="string", length=20, nullable=true)
     */
    private $termname;

    /**
     * @var string
     *
     * @ORM\Column(name="TermColor", type="string", length=20, nullable=true)
     */
    private $termcolor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="TermStartDate", type="date", nullable=true)
     */
    private $termstartdate;


}

