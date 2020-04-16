<?php

namespace CalendarZiedBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

/**
 * Deals
 *
 * @ORM\Table(name="deals", indexes={@ORM\Index(name="deals_FK1", columns={"TermID"}), @ORM\Index(name="deals_FK2", columns={"CalendarName"}),@ORM\Index(name="FK_idU", columns={"idU"})})
 * @ORM\Entity(repositoryClass="CalendarZiedBundle\Repository\DealsRepository")
 * @Vich\Uploadable
 */
class Deals
{

    /**
     * @var string
     * @ORM\Column(name="EventDescription", type="string", length=200, nullable=false)
     * @ORM\Id
     */
    private $eventdescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="EventDate", type="date", nullable=false)
     */
    private $eventdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="TermID", type="integer", nullable=false)
     */
    private $termid;

    /**
     * @var string
     *
     * @ORM\Column(name="CalendarName", type="string", length=200, nullable=false)
     */
    private $calendarname;

    /**
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idU", referencedColumnName="id")
     */
    private $idu;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="start", type="datetime", nullable=true)
     */
    private $start;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;


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
     * @return \DateTime
     */
    public function getEventdate()
    {
        return $this->eventdate;
    }

    /**
     * @param \DateTime $eventdate
     */
    public function setEventdate($eventdate)
    {
        $this->eventdate = $eventdate;
    }

    /**
     * @return int
     */
    public function getTermid()
    {
        return $this->termid;
    }

    /**
     * @param int $termid
     */
    public function setTermid($termid)
    {
        $this->termid = $termid;
    }

    /**
     * @return string
     */
    public function getCalendarname()
    {
        return $this->calendarname;
    }

    /**
     * @param string $calendarname
     */
    public function setCalendarname($calendarname)
    {
        $this->calendarname = $calendarname;
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
     * @return \Datetime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \Datetime $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return \Datetime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param \Datetime $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }




    public function toArray()
    {
        // TODO: Implement toArray() method.
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

