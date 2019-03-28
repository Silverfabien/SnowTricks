<?php

namespace SnowTricksBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use SnowTricksBundle\Entity\Tricks;

class TricksFixtures extends Fixture
{
    const TRICKS_REFERENCE = 'Tricks';

    public function load(ObjectManager $manager)
    {
        $tricksData = [
            [
                'Stalefish',
                'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.',
                'Les Grabs',
                '2019-01-29 18:22:36',
                'stalefish'
            ],
            [
                'Slide',
                'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe
                 de la barre,soit perpendiculaire, soit plus ou moins désaxé. On peut slider avec la planche centrée par
                 rapport à la barre (celle-ci se situe approximativement au-dessous des pieds du rideur)',
                'Slide',
                '2019-01-29 18:29:14',
                'slide'
            ],
            [
                'Alley Oop',
                'Rotation effectuée en half-pipe dont le sens de rotation est inverse au mur. 
                C\'est-à-dire rotation frontside sur un mur backside ou rotation backside sur un mur frontside.',
                'Spin',
                '2019-01-29 18:30:03',
                'alley-oop'
            ],
            [
                'Mute',
                'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.',
                'Les Grabs',
                '2019-01-29 18:30:24',
                'mute'
            ],
            [
                'Ari to Fakie',
                'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.',
                'Les Grabs',
                '2019-01-29 18:30:38',
                'air-to-fakie'
            ],
            [
                'Seat Belt',
                'Saisie du carre frontside à l\'arrière avec la main avant',
                'Les Grabs',
                '2019-01-29 18:31:34',
                'seat-belt'
            ],
            [
                'Big Foot (1080)',
                'Rotation de 1080° soit 3 tours en frontside ou backside.',
                'Rotation',
                '2019-01-29 18:32:31',
                'big-foot-1080'
            ],
            [
                'Front Flips',
                'Un flip est une rotation verticale. Le front flip est un rotation vers l\'avant.',
                'Flips',
                '2019-01-29 18:33:35',
                'front-flips'
            ],
            [
                'Backside Air',
                'Parce qu\'un Backside air, ca se fait sur un hit backside. Un hip comme ici, mais également en pipe ou
                 sur n\'importe quelle transition où la reception est face à vous quand vous êtes en l\'air en saut droit.
                 Si vous prenez un saut droit ou un transfert frontside, dans ce cas vous parlerez de "method".',
                'Old School',
                '2019-01-29 18:34:28',
                'backside-air'
            ],
            [
                'Truck Driver',
                'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)',
                'Les Grabs',
                '2019-01-29 18:35:05',
                'truck-driver'
            ]
        ];

        $i = 0;

        foreach ($tricksData as list($name, $description, $figureGroup, $created, $slug)) {
            $tricks = new Tricks();
            $tricks->setName($name);
            $tricks->setDescription($description);
            $tricks->setFigureGroup($figureGroup);
            $tricks->setCreatedAt(new \DateTime($created));
            $tricks->setSlug($slug);

            $manager->persist($tricks);
            $manager->flush();

            $this->addReference(self::TRICKS_REFERENCE . $i, $tricks);
            $i++;
        }
    }

    public function getOrder()
    {
        return 1;
    }
}