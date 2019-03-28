<?php

namespace SnowTricksBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use SnowTricksBundle\Entity\TricksVideo;

class TricksVideosFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tricksVideosFixtures = [
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '0'),
                'youtube',
                'f9FjhCt_w2U',
                'https://www.youtube.com/watch?v=f9FjhCt_w2U'
            ],
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '0'),
                'youtube',
                'rDzm-lkFAI4',
                'https://www.youtube.com/watch?v=rDzm-lkFAI4'
            ],
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '2'),
                'youtube',
                'FDW2UEk3aXM',
                'https://www.youtube.com/watch?v=FDW2UEk3aXM'
            ]
        ];

        foreach ($tricksVideosFixtures as list($tricks, $type, $identif, $url)) {
            $tricksVideosFixtures = new TricksVideo();
            $tricksVideosFixtures->setTricks($tricks);
            $tricksVideosFixtures->setType($type);
            $tricksVideosFixtures->setIdentif($identif);
            $tricksVideosFixtures->setUrl($url);

            $manager->persist($tricksVideosFixtures);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 3;
    }
}