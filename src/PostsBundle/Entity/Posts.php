<?php

namespace PostsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Posts
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="PostsBundle\Repository\PostsRepository")
 * @Vich\Uploadable
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
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type=0;


    /**
     * @var integer
     *
     * @ORM\Column(name="archive", type="integer", nullable=true)
     */
    private $archive=0;

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

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * @param int $archive
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;
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

