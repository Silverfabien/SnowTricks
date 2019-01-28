<?php

namespace SnowTricksBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * TricksPicture
 *
 * @ORM\Table(name="tricks_picture")
 * @ORM\Entity(repositoryClass="SnowTricksBundle\Repository\TricksPictureRepository")
 */
class TricksPicture
{
    /**
     * @ORM\ManyToOne(targetEntity="SnowTricksBundle\Entity\Tricks", inversedBy="pictures", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tricks;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="fileName", type="string", length=255)
     */
    private $fileName;


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
     * @return ArrayCollection
     */
    public function getTricks()
    {
        return $this->tricks;
    }

    /**
     * @param Tricks $tricks
     *
     * @return TricksPicture
     */
    public function setTricks(Tricks $tricks)
    {
        $this->tricks = $tricks;

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     *
     * @return TricksPicture
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return TricksPicture
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}