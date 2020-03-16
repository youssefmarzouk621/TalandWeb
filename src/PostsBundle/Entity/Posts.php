<?php

namespace PostsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Posts
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity
 */
class Posts
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idPost", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpost;


    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idU", referencedColumnName="id")
     */
    private $idu;



    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;







    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=false)
     */
    private $source;







    /**
     * @var integer
     *
     * @ORM\Column(name="nbrlikes", type="integer", nullable=false)
     */
    private $nbrlikes;






    /**
     * @var integer
     *
     * @ORM\Column(name="nbrcomments", type="integer", nullable=false)
     */
    private $nbrcomments;






    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime", nullable=false)
     */
    private $datecreation = 'CURRENT_TIMESTAMP';

    /**
     * @return int
     */
    public function getIdpost()
    {
        return $this->idpost;
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return int
     */
    public function getNbrlikes()
    {
        return $this->nbrlikes;
    }

    /**
     * @param int $nbrlikes
     */
    public function setNbrlikes($nbrlikes)
    {
        $this->nbrlikes = $nbrlikes;
    }

    /**
     * @return int
     */
    public function getNbrcomments()
    {
        return $this->nbrcomments;
    }

    /**
     * @param int $nbrcomments
     */
    public function setNbrcomments($nbrcomments)
    {
        $this->nbrcomments = $nbrcomments;
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


}

