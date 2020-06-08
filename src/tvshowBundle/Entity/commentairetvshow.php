<?php

namespace tvshowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * commentairetvshow
 *
 * @ORM\Table(name="commentairetvshow")
 * @ORM\Entity(repositoryClass="tvshowBundle\Repository\commentairetvshowRepository")
 */
class commentairetvshow
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
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="\tvshowBundle\Entity\Tvshow")
     * @ORM\JoinColumn(name="idtvshow" ,referencedColumnName="id",onDelete="CASCADE")
     */
    private $tvshow;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id")
     */
    private  $User_id;
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
     * Set content
     *
     * @param string $content
     *
     * @return commentairetvshow
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
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
     * @return commentairetvshow
     */
    public function setUserId($User_id)
    {
        $this->User_id = $User_id;
        return $this;
    }





    /**
     * Set tvshow
     *
     * @param \tvshowBundle\Entity\Tvshow $tvshow
     *
     * @return commentairetvshow
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
}
