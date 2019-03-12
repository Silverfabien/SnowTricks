<?php

namespace SnowTricksBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use SnowTricksBundle\Entity\UserPicture;
use SnowTricksBundle\Uploader\PictureUploader;

class UserPictureListener
{
    private $pictureUploader;

    public function __construct(PictureUploader $pictureUploader)
    {
        $this->pictureUploader = $pictureUploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof UserPicture)
        {
            return;
        }

        $fileName = $this->pictureUploader->upload($entity);

        if($fileName === null)
        {
            return;
        }

        $entity->setFileName($fileName);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof UserPicture)
        {
            return;
        }

        $this->pictureUploader->remove($entity);
    }
}