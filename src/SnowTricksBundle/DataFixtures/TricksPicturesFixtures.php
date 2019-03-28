<?php

namespace SnowTricksBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use SnowTricksBundle\Entity\TricksPicture;

class TricksPicturesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tricksPicturesData = [
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '0'),
                '4bf96e6a5c85e5d07cbb2c4efdbaeff7.jpeg'
            ],
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '0'),
                'd6bacf9d96604655bdc2c0498309bda2.jpeg'
            ],
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '0'),
                '6a039a442443bc4f0ca85745aaebc5d3.jpeg'
            ],
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '0'),
                '147625cebeed0dfcf6b054e260b3b5a3.jpeg'
            ],
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '1'),
                'd72799518849d00b2664fb8e8f43e852.jpeg'
            ],
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '4'),
                '100dc440b61b5c40fd9d3720693848d5.jpeg'
            ],
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '5'),
                '541162b819804a07897f79632ee1ed45.jpeg'
            ],
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '8'),
                '0573315536209b7cef84ecd34209962d.jpeg'
            ],
            [
                $this->getReference(TricksFixtures::TRICKS_REFERENCE . '9'),
                '97398a3620c205d606a5711458e2e128.jpeg'
            ]
        ];

        foreach ($tricksPicturesData as list($tricks, $fileName)) {
            $tricksPicturesData = new TricksPicture();
            $tricksPicturesData->setTricks($tricks);
            $tricksPicturesData->setFileName($fileName);

            $manager->persist($tricksPicturesData);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 2;
    }
}