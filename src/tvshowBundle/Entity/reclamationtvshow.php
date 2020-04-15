<?php

namespace tvshowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * reclamationtvshow
 *
 * @ORM\Table(name="reclamationtvshow")
 * @ORM\Entity(repositoryClass="tvshowBundle\Repository\reclamationtvshowRepository")
 */
class reclamationtvshow
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="\tvshowBundle\Entity\Tvshow")
     * @ORM\JoinColumn(name="idtvshow" ,referencedColumnName="id")
     */
    private $idtvshow;


    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User",cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="idu", referencedColumnName="id" ,nullable=true)
     */
    private $idu;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="string", length=255)
     */
    private $reason;

    /**
     * @var string
     *
     * @ORM\Column(name="responsetype", type="string", length=255)
     */
    private $responsetype;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer" , options={"default" : 0})
     */
    private $etat;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set tvshow
     *
     * @param \tvshowBundle\Entity\Tvshow $tvshow
     *
     * @return commentairetvshow
     */
    public function setTvshow(\tvshowBundle\Entity\Tvshow $idtvshow = null)
    {
        $this->idtvshow = $idtvshow;

        return $this;
    }

    /**
     * Get tvshow
     *
     * @return \tvshowBundle\Entity\Tvshow
     */
    public function getTvshow()
    {
        return $this->idtvshow;
    }


    /**
     * Set idu
     *
     * @param mixed $idu
     *
     * @return reclamationtvshow
     */
    public function setIdu($idu)
    {
        $this->idu = $idu;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdu()
    {
        return $this->idu;
    }

    /**
     * Set reason
     *
     * @param string $reason
     *
     * @return reclamationtvshow
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set responsetype
     *
     * @param string $responsetype
     *
     * @return reclamationtvshow
     */
    public function setResponsetype($responsetype)
    {
        $this->responsetype = $responsetype;

        return $this;
    }

    /**
     * Get responsetype
     *
     * @return string
     */
    public function getResponsetype()
    {
        return $this->responsetype;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return reclamationtvshow
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }
}

