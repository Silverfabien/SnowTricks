<?php

namespace SnowTricksBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use SnowTricksBundle\Entity\Tricks;

class TricksControllerTest extends TestCase
{
    public function testSlugUppercase()
    {
        $trick = new Tricks();
        $trick->setName('Snow');
        $this->assertEquals('snow', $trick->getSlug());
    }

    public function testSlugFullUppercase()
    {
        $trick = new Tricks();
        $trick->setName('SNOWBOARD');
        $this->assertEquals('snowboard', $trick->getSlug());
    }

    public function testSlugTiny()
    {
        $trick = new Tricks();
        $trick->setName('tricks');
        $this->assertEquals('tricks', $trick->getSlug());
    }

    public function testSlugSpace()
    {
        $trick = new Tricks();
        $trick->setName('Une Figure');
        $this->assertEquals('une-figure', $trick->getSlug());
    }

    public function testSlugHyphen()
    {
        $trick = new Tricks();
        $trick->setName("Une-Figure");
        $this->assertEquals('une-figure', $trick->getSlug());
    }

    public function testSlugSpecialCharacters()
    {
        $trick = new Tricks();
        $trick->setName('Une Figure (1080)');
        $this->assertEquals('une-figure-1080', $trick->getSlug());
    }

    public function testCreatedTricks()
    {
        $trick = new Tricks();
        $trick->setCreatedAt(new \DateTime());
        $this->assertEquals(new \DateTime(), $trick->getCreatedAt());
    }
}