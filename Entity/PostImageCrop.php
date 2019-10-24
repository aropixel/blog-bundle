<?php

namespace Aropixel\BlogBundle\Entity;

use Aropixel\AdminBundle\Entity\Crop;
use Doctrine\ORM\Mapping as ORM;

/**
 * PostImageCrop
 */
class PostImageCrop extends Crop
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var PostImage
     */
    private $image;



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
