<?php

namespace tvshowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ratingtvshow
 *
 * @ORM\Table(name="ratingtvshow")
 * @ORM\Entity(repositoryClass="tvshowBundle\Repository\ratingtvshowRepository")
 */
class ratingtvshow
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
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User",cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id" ,nullable=true)
     */
    private  $User_id;

    /**
     * @ORM\ManyToOne(targetEntity="\tvshowBundle\Entity\Tvshow")
     * @ORM\JoinColumn(name="idtvshow" ,referencedColumnName="id")
     */
    private $tvshow;
    /**
     * @var int
     *
     * @ORM\Column(name="rate", type="integer")
     */
    private $rate;


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
     * @return ratingtvshow
     */
    public function setTvshow(\tvshowBundle\Entity\Tvshow $tvshow = null)
    {
        $this->tvshow = $tvshow;

        return $this;
    }

    /**
     * Get tvshow
     *
     * @return \tvshowBundle\Entity\Tvshow
     */
    public function getTvshow()
    {
        return $this->tvshow;
    }





    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->User_id;
    }

    /**
     * @param mixed $User_id
     * @return ratingtvshow
     */
    public function setUserId($User_id)
    {
        $this->User_id = $User_id;
        return $this;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     *
     * @return ratingtvshow
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return int
     */
    public function getRate()
    {
        return $this->rate;
    }
}
