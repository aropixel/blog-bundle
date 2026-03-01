<?php

namespace Aropixel\BlogBundle\Entity;

use Aropixel\AdminBundle\Entity\AttachedImageInterface;
use Aropixel\AdminBundle\Entity\Crop;
use Aropixel\BlogBundle\Repository\PostImageCropRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostImageCropRepository::class)]
#[ORM\Table(name: 'aropixel_post_image_crop')]
class PostImageCrop extends Crop
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: PostImage::class, inversedBy: 'crops')]
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
