<?php

namespace EventsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Events
 *
 * @ORM\Table(name="events", indexes={@ORM\Index(name="IDX_5387574AA2D72265", columns={"idU"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="EventsBundle\Repository\EventsRepository")
 * @Vich\Uploadable
 */
class Events
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idEvent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevent;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

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
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="price_event", type="float", precision=10, scale=0, nullable=false)
     */
    private $priceEvent;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat_event", type="integer", nullable=false)
     */
    private $etatEvent;

    /**
     * @var integer
     *
     * @ORM\Column(name="spec_max", type="integer", nullable=false)
     */
    private $specMax;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idU", referencedColumnName="id")
     */
    private $idu;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrspectateurevent", type="integer", nullable=false)
     */
    private $nbrspectateurevent;




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
    public function getIdevent()
    {
        return $this->idevent;
    }

    /**
     * @param int $idevent
     */
    public function setIdevent($idevent)
    {
        $this->idevent = $idevent;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getPriceEvent()
    {
        return $this->priceEvent;
    }

    /**
     * @param float $priceEvent
     */
    public function setPriceEvent($priceEvent)
    {
        $this->priceEvent = $priceEvent;
    }

    /**
     * @return int
     */
    public function getEtatEvent()
    {
        return $this->etatEvent;
    }

    /**
     * @param int $etatEvent
     */
    public function setEtatEvent($etatEvent)
    {
        $this->etatEvent = $etatEvent;
    }

    /**
     * @return int
     */
    public function getSpecMax()
    {
        return $this->specMax;
    }

    /**
     * @param int $specMax
     */
    public function setSpecMax($specMax)
    {
        $this->specMax = $specMax;
    }

    /**
     * @return int
     */
    public function getNbrspectateurevent()
    {
        return $this->nbrspectateurevent;
    }

    /**
     * @param int $nbrspectateurevent
     */
    public function setNbrspectateurevent($nbrspectateurevent)
    {
        $this->nbrspectateurevent = $nbrspectateurevent;
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

