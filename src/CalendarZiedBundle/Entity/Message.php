<?php

namespace CalendarZiedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="CalendarZiedBundle\Repository\MessageRepository")
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idmessage", type="integer", nullable=false)
     * @ORM\Id
     *@ORM\GeneratedValue(strategy="AUTO")
     */
    private $idmessage;

    /**
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idU", referencedColumnName="id")
     */
    private $idu;

    /**
     * @var integer
     *
     * @ORM\Column(name="idreceiver", type="integer", nullable=false)
     */
    private $idreceiver;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=400, nullable=false)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateenvoi", type="datetime", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     */
    private $dateenvoi;

    /**
     * @var integer
     *
     * @ORM\Column(name="etatmessage", type="integer", nullable=true)
     */
    private $etatmessage=0;

    /**
     * @var string
     *
     * @ORM\Column(name="EventDescription", type="string", length=255, nullable=true)
     */
    private $eventdescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="seen", type="integer", nullable=true)
     */
    private $seen=0;

    /**
     * @return int
     */
    public function getIdmessage()
    {
        return $this->idmessage;
    }

    /**
     * @param int $idmessage
     */
    public function setIdmessage($idmessage)
    {
        $this->idmessage = $idmessage;
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
    public function getIdreceiver()
    {
        return $this->idreceiver;
    }

    /**
     * @param int $idreceiver
     */
    public function setIdreceiver($idreceiver)
    {
        $this->idreceiver = $idreceiver;
    }

    /**
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param string $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @return \DateTime
     */
    public function getDateenvoi()
    {
        return $this->dateenvoi;
    }

    /**
     * @param \DateTime $dateenvoi
     */
    public function setDateenvoi($dateenvoi)
    {
        $this->dateenvoi = $dateenvoi;
    }

    /**
     * @return int
     */
    public function getEtatmessage()
    {
        return $this->etatmessage;
    }

    /**
     * @param int $etatmessage
     */
    public function setEtatmessage($etatmessage)
    {
        $this->etatmessage = $etatmessage;
    }

    /**
     * @return string
     */
    public function getEventdescription()
    {
        return $this->eventdescription;
    }

    /**
     * @param string $eventdescription
     */
    public function setEventdescription($eventdescription)
    {
        $this->eventdescription = $eventdescription;
    }

    /**
     * @return int
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * @param int $seen
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
    }



}

