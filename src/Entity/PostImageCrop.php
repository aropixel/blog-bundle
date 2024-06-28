<?php

namespace Aropixel\BlogBundle\Entity;

use Aropixel\AdminBundle\Entity\Crop;
use Aropixel\BlogBundle\Repository\PostImageCropRepository;
use Doctrine\ORM\Mapping as ORM;


class PostImageCrop extends Crop
{
    private ?int $id = null;

    private ?PostImage $image = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?PostImage
    {
        return $this->image;
    }

    public function setImage(?PostImage $image): self
    {
        $this->image = $image;

        return $this;
    }
}
