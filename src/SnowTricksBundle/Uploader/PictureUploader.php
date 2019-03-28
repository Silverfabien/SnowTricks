<?php

namespace SnowTricksBundle\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureUploader implements Uploader
{
    public function upload($picture)
    {
        if (!$picture->getFile() instanceof UploadedFile) {
            return null;
        }

        $fileName = sha1(uniqid()) . '.' . $picture->getFile()->guessExtension();
        $picture->getFile()->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    public function remove($picture)
    {
        unlink($this->getTargetDirectory() . $picture->getFileName());
    }

    public function getTargetDirectory()
    {
        return 'uploads/pictures/';
    }
}