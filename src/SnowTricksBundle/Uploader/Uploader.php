<?php

namespace SnowTricksBundle\Uploader;

interface Uploader
{
    public function upload($entity);

    public function getTargetDirectory();
}