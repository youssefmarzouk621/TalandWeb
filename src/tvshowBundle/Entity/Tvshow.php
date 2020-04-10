<?php

namespace tvshowBundle\Entity;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @Assert\File(maxSize="500k")
     */
    public $file;
    /**
     * @var string
     *
     * @ORM\Column(name="galeryimage1", type="string", length=255, nullable=true)
     */
    private $galeryimage1;
    /**
     * @Assert\File(maxSize="500k")
     */
    public $file1;
    /**
     * @var string
     *
     * @ORM\Column(name="galeryimage2", type="string", length=255, nullable=true)
     */
    private $galeryimage2;
    /**
     * @Assert\File(maxSize="500k")
     */
    public $file2;
    /**
     * @var string
     *
     * @ORM\Column(name="galeryimage3", type="string", length=255, nullable=true)
     */
    private $galeryimage3;
    /**
     * @Assert\File(maxSize="500k")
     */
    public $file3;
    /**
     * @var string
     *
     * @ORM\Column(name="galeryimage4", type="string", length=255, nullable=true)
     */
    private $galeryimage4;
    /**
     * @Assert\File(maxSize="500k")
     */
    public $file4;
    /**
     * @var string
     *
     * @ORM\Column(name="galeryimage5", type="string", length=255, nullable=true)
     */
    private $galeryimage5;
    /**
     * @Assert\File(maxSize="500k")
     */
    public $file5;

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

    public function getWebPath()
    {
        return null===$this->coverimage ? null :$this->getUploadDir().''.$this->coverimage();
    }
    public function getWeb1Path()
    {
        return null===$this->galeryimage1 ? null :$this->getUploadDir().''.$this->galeryimage1();
    }
    public function getWeb2Path()
    {
        return null===$this->galeryimage2 ? null :$this->getUploadDir().''.$this->galeryimage2();
    }
    public function getWeb3Path()
    {
        return null===$this->galeryimage3 ? null :$this->getUploadDir().''.$this->galeryimage3();
    }
    public function getWeb4Path()
    {
        return null===$this->galeryimage4 ? null :$this->getUploadDir().''.$this->galeryimage4();
    }
    public function getWeb5Path()
    {
        return null===$this->galeryimage5 ? null :$this->getUploadDir().''.$this->galeryimage5();
    }
    protected function getUploadRootDir()
    {
        return _DIR_.'/../../../../web'.$this->getUploadDir();
    }
    protected function getUploadDir()
    {
        return 'images';
    }
    public function uploadProfilePicture()
    {
        if( $this->file==null) {
            $this->coverimage= $this->coverimage;

        }
        else {

            $this->file->move($this->getUploadDir(), $this->file->getClientOriginalName());
            $this->coverimage = $this->file->getClientOriginalName();
            $this->file = null;
        }
    }
    public function uploadgaleriepicture1()
    {
        if( $this->file1==null) {
            $this->galeryimage1= $this->galeryimage1;

        }
        else {
            $this->file1->move($this->getUploadDir(), $this->file1->getClientOriginalName());
            $this->galeryimage1 = $this->file1->getClientOriginalName();
            $this->file1 = null;
        }
    }
    public function uploadgaleriepicture2()
    {
        if( $this->file2==null) {
            $this->galeryimage2= $this->galeryimage2;

        }
        else {
            $this->file2->move($this->getUploadDir(), $this->file2->getClientOriginalName());
            $this->galeryimage2 = $this->file2->getClientOriginalName();
            $this->file2 = null;
        }
    }
    public function uploadgaleriepicture3()
    {
        if( $this->file3==null) {
            $this->galeryimage3= $this->galeryimage3;

        }
        else {
            $this->file3->move($this->getUploadDir(), $this->file3->getClientOriginalName());
            $this->galeryimage3 = $this->file3->getClientOriginalName();
            $this->file3 = null;
        }
    }
    public function uploadgaleriepicture4()
    {
        if( $this->file4==null) {
            $this->galeryimage4= $this->galeryimage4;

        }
        else {
            $this->file4->move($this->getUploadDir(), $this->file4->getClientOriginalName());
            $this->galeryimage4 = $this->file4->getClientOriginalName();
            $this->file4 = null;
        }
    }
    public function uploadgaleriepicture5()
    {
        if( $this->file4==null) {
            $this->galeryimage4= $this->galeryimage4;

        }
        else {
            $this->file5->move($this->getUploadDir(), $this->file5->getClientOriginalName());
            $this->galeryimage5 = $this->file5->getClientOriginalName();
            $this->file5 = null;
        }
    }
}
