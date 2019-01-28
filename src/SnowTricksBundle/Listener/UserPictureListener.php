<?php

namespace SnowTricksBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use SnowTricksBundle\Entity\UserPicture;
use SnowTricksBundle\Uploader\Uploader;

class UserPictureListener
{
    private $userPictureUploader;

    public function __construct(Uploader $pictureUploader)
    {
        $this->userPictureUploader = $pictureUploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof UserPicture)
        {
            return;
        }

        $fileName = $this->userPictureUploader->upload($entity);

        if($fileName === null)
        {
            return;
        }

        $entity->setFileName($fileName);
    }
}