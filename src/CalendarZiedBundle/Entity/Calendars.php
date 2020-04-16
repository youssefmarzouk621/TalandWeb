<?php

namespace CalendarZiedBundle\Entity;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

/**
 * Calendars
 *
 * @ORM\Table(name="calendars")
 * @ORM\Entity(repositoryClass="CalendarZiedBundle\Repository\CalendarsRepository")
 */
class Calendars
{
    /**
     * @var string
     *
     * @ORM\Column(name="CalendarName", type="string", length=200, nullable=false)
     * @ORM\Id
     *
     */
    private $calendarname;

    /**
     * @var integer
     *
     * @ORM\Column(name="StartYear", type="integer", nullable=true)
     */
    private $startyear;

    /**
     * @var integer
     *
     * @ORM\Column(name="EndYear", type="integer", nullable=true)
     */
    private $endyear;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="StartDate", type="date", nullable=true)
     */
    private $startdate;

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
     * @var integer
     *
     * @ORM\Column(name="idU", type="integer", nullable=true)
     */
    private $idu;

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
     * @return int
     */
    public function getStartyear()
    {
        return $this->startyear;
    }

    /**
     * @param int $startyear
     */
    public function setStartyear($startyear)
    {
        $this->startyear = $startyear;
    }

    /**
     * @return int
     */
    public function getEndyear()
    {
        return $this->endyear;
    }

    /**
     * @param int $endyear
     */
    public function setEndyear($endyear)
    {
        $this->endyear = $endyear;
    }

    /**
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * @param \DateTime $startdate
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;
    }

    public function __toString()
    {
        return $this->calendarname;
    }


}

