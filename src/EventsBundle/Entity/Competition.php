<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * Competition
 *
 * @ORM\Table(name="competition", indexes={@ORM\Index(name="IDX_B50A2CB1A2D72265", columns={"idU"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="EventsBundle\Repository\EventsRepository")
 * @Vich\Uploadable
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
     * @ORM\Column(name="lat", type="string", length=255, nullable=false)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lng", type="string", length=255, nullable=false)
     */
    private $lng;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startingdate", type="date")
     */
    private $startingdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endingdate", type="date")
     */
    private $endingdate;

    /**
     * @var float
     *
     * @ORM\Column(name="pricecomp", type="float", precision=10, scale=0, nullable=false)
     */
    private $pricecomp;

    /**
     * @ORM\ManyToOne(targetEntity="EventsBundle\Entity\Category")
     * @ORM\JoinColumn(name="idcat", referencedColumnName="id")
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
    private $nbrspec;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrparticipant", type="integer", nullable=false)
     */
    private $nbrparticipant;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idU", referencedColumnName="id")
     */
    private $idu;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="commentaire_file", fileNameProperty="imageName", size="imageSize")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;
    /**
     * @return int
     */
    public function getIdcomp()
    {
        return $this->idcomp;
    }



    /**
     * @return string
     */
    public function getNamecomp()
    {
        return $this->namecomp;
    }

    /**
     * @param string $namecomp
     */
    public function setNamecomp($namecomp)
    {
        $this->namecomp = $namecomp;
    }

    /**
     * @return string
     */
    public function getDesccomp()
    {
        return $this->desccomp;
    }

    /**
     * @param string $desccomp
     */
    public function setDesccomp($desccomp)
    {
        $this->desccomp = $desccomp;
    }

    /**
     * @return int
     */
    public function getNbrmaxspec()
    {
        return $this->nbrmaxspec;
    }

    /**
     * @param int $nbrmaxspec
     */
    public function setNbrmaxspec($nbrmaxspec)
    {
        $this->nbrmaxspec = $nbrmaxspec;
    }

    /**
     * @return int
     */
    public function getNbrmaxpar()
    {
        return $this->nbrmaxpar;
    }

    /**
     * @param int $nbrmaxpar
     */
    public function setNbrmaxpar($nbrmaxpar)
    {
        $this->nbrmaxpar = $nbrmaxpar;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param string $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return \DateTime
     */
    public function getStartingdate()
    {
        return $this->startingdate;
    }

    /**
     * @param \DateTime $startingdate
     */
    public function setStartingdate($startingdate)
    {
        $this->startingdate = $startingdate;
    }

    /**
     * @return \DateTime
     */
    public function getEndingdate()
    {
        return $this->endingdate;
    }

    /**
     * @param \DateTime $endingdate
     */
    public function setEndingdate($endingdate)
    {
        $this->endingdate = $endingdate;
    }



    /**
     * @return float
     */
    public function getPricecomp()
    {
        return $this->pricecomp;
    }

    /**
     * @param float $pricecomp
     */
    public function setPricecomp($pricecomp)
    {
        $this->pricecomp = $pricecomp;
    }

    /**
     * @return mixed
     */
    public function getIdcat()
    {
        return $this->idcat;
    }

    /**
     * @param mixed $idcat
     */
    public function setIdcat($idcat)
    {
        $this->idcat = $idcat;
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

    /**
     * @return int
     */
    public function getNbrspec()
    {
        return $this->nbrspec;
    }

    /**
     * @param int $nbrspec
     */
    public function setNbrspec($nbrspec)
    {
        $this->nbrspec = $nbrspec;
    }

    /**
     * @return int
     */
    public function getNbrparticipant()
    {
        return $this->nbrparticipant;
    }

    /**
     * @param int $nbrparticipant
     */
    public function setNbrparticipant($nbrparticipant)
    {
        $this->nbrparticipant = $nbrparticipant;
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
     * @param File $imageFile
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

    }


    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }


    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

}

