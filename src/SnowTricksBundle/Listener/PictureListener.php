<?php

namespace SnowTricksBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use SnowTricksBundle\Entity\TricksPicture;
use SnowTricksBundle\Uploader\PictureUploader;

class PictureListener
{
    private $pictureUploader;

    public function __construct(PictureUploader $pictureUploader)
    {
        $this->pictureUploader = $pictureUploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof TricksPicture) {
            return;
        }

        $fileName = $this->pictureUploader->upload($entity);

        if ($fileName === null) {
            return;
        }

        $entity->setFileName($fileName);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof TricksPicture) {
            return;
        }

        $this->pictureUploader->remove($entity);
    }
}