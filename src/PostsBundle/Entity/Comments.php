<?php

namespace PostsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity
 */
class Comments
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idComment", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcomment;



    /**
     * @ORM\ManyToOne(targetEntity="Posts")
     * @ORM\JoinColumn(name="idPost", referencedColumnName="idPost", onDelete="CASCADE")
     */
    private $idpost;



    /**
     * @var integer
     *
     * @ORM\Column(name="idU", type="integer", nullable=false)
     */
    private $idu;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255, nullable=false)
     */



    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime", nullable=false)
     */



    private $datecreation = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */


    private $etat = '0';

    /**
     * @return int
     */
    public function getIdcomment()
    {
        return $this->idcomment;
    }


    /**
     * @return mixed
     */
    public function getIdpost()
    {
        return $this->idpost;
    }

    /**
     * @param mixed $idpost
     */
    public function setIdpost($idpost)
    {
        $this->idpost = $idpost;
    }


    /**
     * @return int
     */
    public function getIdu()
    {
        return $this->idu;
    }

    /**
     * @param int $idu
     */
    public function setIdu($idu)
    {
        $this->idu = $idu;
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
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * @param \DateTime $datecreation
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;
    }

    /**
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param int $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }


}

