<?php

namespace SnowTricksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Tricks
 *
 * @ORM\Table(name="tricks")
 * @ORM\Entity(repositoryClass="SnowTricksBundle\Repository\TricksRepository")
 */
class Tricks
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
     * @ORM\Column(name="name", type="string", length=35, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="figureGroup", type="string", length=255)
     */
    private $figureGroup;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

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
     * @return Tricks
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->setSlug($this->name);
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
     * Set description
     *
     * @param string $description
     *
     * @return Tricks
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
     * Set figureGroup
     *
     * @param string $figureGroup
     *
     * @return Tricks
     */
    public function setFigureGroup($figureGroup)
    {
        $this->figureGroup = $figureGroup;

        return $this;
    }

    /**
     * Get figureGroup
     *
     * @return string
     */
    public function getFigureGroup()
    {
        return $this->figureGroup;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Tricks
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Tricks
     */
    public function setSlug($slug)
    {
        $this->slug = $this->slugify($slug);
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function slugify($name)
    {
        $name = preg_replace('#[^\\pL\d]+#u', '-', $name);
        $name = trim($name, '-');

        if(function_exists('iconv'))
        {
            $name = iconv('utf-8', 'us-ascii//TRANSLIT', $name);
        }

        $name = strtolower($name);
        $name = preg_replace('#[^-\w]+#', '', $name);

        if(empty($name))
        {
            return 'n-a';
        }

        return $name;
    }
}