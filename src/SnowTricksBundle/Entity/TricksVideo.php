<?php

namespace SnowTricksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TricksVideo
 *
 * @ORM\Table(name="tricks_video")
 * @ORM\Entity(repositoryClass="SnowTricksBundle\Repository\TricksVideoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class TricksVideo
{
    /**
     * @ORM\ManyToOne(targetEntity="SnowTricksBundle\Entity\Tricks", inversedBy="videos", cascade={"persist"})
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="identif", type="string", length=255)
     */
    private $identif;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     *
     * @Assert\Regex(
     *     pattern="#^(http|https)://www.youtube.com|www.dailymotion.com)/#",
     *     match=true,
     *     message="L'url de la vidéo doit être une source de Youtube ou Daylimotion"
     * )
     */
    private $url;

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
     * Set type
     *
     * @param string $type
     *
     * @return TricksVideo
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
     * Set identif
     *
     * @param string $identif
     *
     * @return TricksVideo
     */
    public function setIdentif($identif)
    {
        $this->identif = $identif;

        return $this;
    }

    /**
     * Get identif
     *
     * @return string
     */
    public function getIdentif()
    {
        return $this->identif;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return TricksVideo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    private function youtubeId($url)
    {
        $youtube = explode("=", $url);

        $this->setIdentif($youtube[1]);
        $this->setType('youtube');
    }

    private function dailymotionId($url)
    {
        $dailymotion = explode("/", $url);
        $idb = $dailymotion[4];
        $bp = explode("_", $idb);
        $id = $bp[0];
        $this->setIdentif($id);
        $this->setType('dailymotion');

    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @ORM\PreFlush()
     */

    public function extractIdentif()
    {
        $url = $this->getUrl();

        if(preg_match("#^(http|https)://www.youtube.com/#", $url))
        {
            $this->youtubeId($url);
        }
        elseif(preg_match("#^(http|https)://www.dailymotion.com/#", $url))
        {
            $this->dailymotionId($url);
        }
    }

    public function urlIFrame()
    {
        switch($this->type)
        {
            case 'youtube':
                return 'https://www.youtube-nocookie.com/embed/'.strip_tags($this->getIdentif());
            case 'dailymotion':
                return 'https://www.dailymotion.com/embed/video/'.strip_tags($this->getIdentif());
        }
    }

    public function image()
    {
        $control = $this->getType();
        $id = strip_tags($this->getIdentif());

        if($control == 'youtube')
        {
            $picture = 'https://www.youtbe.com/vi/'.$id.'hqdefault.jpg';

            return $picture;
        }
        elseif($control == 'dailymotion')
        {
            $picture = 'https://www.dailymotion.com/thumbmail/150x120/video/'.$id.'';

            return $picture;
        }
    }

    public function htmlVideoIFrame()
    {
        return '<iframe width="190px" height="150px" style="padding-left: 2px; margin-top: 5px; margin-bottom: -6.5px" src="'.$this->urlIFrame().'" frameborder="0" allowfullscreen></iframe>';
    }

    /**
     * @return Tricks
     */
    public function getTricks()
    {
        return $this->tricks;
    }

    /**
     * @param Tricks $tricks
     *
     * @return TricksVideo
     */
    public function setTricks(Tricks $tricks)
    {
        $this->tricks = $tricks;

        return $this;
    }
}