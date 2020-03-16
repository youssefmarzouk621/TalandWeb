<?php

namespace PostsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Likes
 *
 * @ORM\Table(name="likes")
 * @ORM\Entity
 */
class Likes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idLike", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idlike;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPost", type="integer", nullable=false)
     */
    private $idpost;

    /**
     * @var integer
     *
     * @ORM\Column(name="idU", type="integer", nullable=false)
     */
    private $idu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime", nullable=true)
     */
    private $datecreation = 'CURRENT_TIMESTAMP';


}

