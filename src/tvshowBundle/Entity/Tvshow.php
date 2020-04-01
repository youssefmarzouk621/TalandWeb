<?php

namespace tvshowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tvshow
 * @ORM\Entity(repositoryClass="tvshowBundle\Repository\TvshowRepository")
 * @ORM\Table(name="tvshow")
 * @ORM\Entity
 */
class Tvshow
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="episodenum", type="integer")
     */
    private $episodenum;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="duree", type="integer")
     */
    private $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;



    /**
     * @var string
     *
     * @ORM\Column(name="coverimage", type="string", length=255)
     */
    private $coverimage;

    /**
     * @var string
     *
     * @ORM\Column(name="galeryimage1", type="string", length=255, nullable=true)
     */
    private $galeryimage1;

    /**
     * @var string
     *
     * @ORM\Column(name="galeryimage2", type="string", length=255, nullable=true)
     */
    private $galeryimage2;

    /**
     * @var string
     *
     * @ORM\Column(name="galeryimage3", type="string", length=255, nullable=true)
     */
    private $galeryimage3;

    /**
     * @var string
     *
     * @ORM\Column(name="galeryimage4", type="string", length=255, nullable=true)
     */
    private $galeryimage4;

    /**
     * @var string
     *
     * @ORM\Column(name="galeryimage5", type="string", length=255, nullable=true)
     */
    private $galeryimage5;


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
     * Set name
     *
     * @param string $name
     *
     * @return Post
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set episodenum
     *
     * @param integer $episodenum
     *
     * @return Post
     */
    public function setEpisodenum($episodenum)
    {
        $this->episodenum = $episodenum;

        return $this;
    }

    /**
     * Get episodenum
     *
     * @return int
     */
    public function getEpisodenum()
    {
        return $this->episodenum;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Post
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return Post
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Post
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Post
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Post
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }


    /**
     * Set coverimage
     *
     * @param string $coverimage
     *
     * @return Post
     */
    public function setCoverimage($coverimage)
    {
        $this->coverimage = $coverimage;

        return $this;
    }

    /**
     * Get coverimage
     *
     * @return string
     */
    public function getCoverimage()
    {
        return $this->coverimage;
    }

    /**
     * Set galeryimage1
     *
     * @param string $galeryimage1
     *
     * @return Post
     */
    public function setGaleryimage1($galeryimage1)
    {
        $this->galeryimage1 = $galeryimage1;

        return $this;
    }

    /**
     * Get galeryimage1
     *
     * @return string
     */
    public function getGaleryimage1()
    {
        return $this->galeryimage1;
    }

    /**
     * Set galeryimage2
     *
     * @param string $galeryimage2
     *
     * @return Post
     */
    public function setGaleryimage2($galeryimage2)
    {
        $this->galeryimage2 = $galeryimage2;

        return $this;
    }

    /**
     * Get galeryimage2
     *
     * @return string
     */
    public function getGaleryimage2()
    {
        return $this->galeryimage2;
    }

    /**
     * Set galeryimage3
     *
     * @param string $galeryimage3
     *
     * @return Post
     */
    public function setGaleryimage3($galeryimage3)
    {
        $this->galeryimage3 = $galeryimage3;

        return $this;
    }

    /**
     * Get galeryimage3
     *
     * @return string
     */
    public function getGaleryimage3()
    {
        return $this->galeryimage3;
    }

    /**
     * Set galeryimage4
     *
     * @param string $galeryimage4
     *
     * @return Post
     */
    public function setGaleryimage4($galeryimage4)
    {
        $this->galeryimage4 = $galeryimage4;

        return $this;
    }

    /**
     * Get galeryimage4
     *
     * @return string
     */
    public function getGaleryimage4()
    {
        return $this->galeryimage4;
    }

    /**
     * Set galeryimage5
     *
     * @param string $galeryimage5
     *
     * @return Post
     */
    public function setGaleryimage5($galeryimage5)
    {
        $this->galeryimage5 = $galeryimage5;

        return $this;
    }

    /**
     * Get galeryimage5
     *
     * @return string
     */
    public function getGaleryimage5()
    {
        return $this->galeryimage5;
    }
}

