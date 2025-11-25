<?php

namespace Aropixel\BlogBundle\Entity;

use Aropixel\AdminBundle\Entity\AttachedImageInterface;
use Aropixel\AdminBundle\Entity\Crop;


class PostImageCrop extends Crop
{
    private ?int $id = null;

    private ?PostImage $image = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): AttachedImageInterface
    {
        return $this->image;
    }

    public function setImage(?PostImage $image): self
    {
        $this->image = $image;

        return $this;
    }
}
