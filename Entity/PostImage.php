<?php

namespace Aropixel\BlogBundle\Entity;

use Aropixel\AdminBundle\Entity\AttachImage;
use Aropixel\AdminBundle\Entity\CroppableInterface;
use Aropixel\AdminBundle\Entity\CroppableTrait;
use Aropixel\BlogBundle\Repository\PostImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: PostImageRepository::class)]
#[ORM\Table(name: "aropixel_post_image")]
class PostImage extends AttachImage implements CroppableInterface
{

    use CroppableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: "image", targetEntity: Post::class)]
    private ?Post $post = null;

    #[ORM\OneToMany(mappedBy: "image", targetEntity: PostImageCrop::class, cascade: ["persist", "remove"])]
    private Collection $crops;


    public function __construct()
    {
        $this->crops = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        // set (or unset) the owning side of the relation if necessary
        $newImage = $post === null ? null : $this;
        if ($newImage !== $post->getImage()) {
            $post->setImage($newImage);
        }

        return $this;
    }

    /**
     * @return Collection|PostImageCrop[]
     */
    public function getCrops(): Collection
    {
        if (is_null($this->crops)) {
            $this->crops = new ArrayCollection();
        }

        return $this->crops;
    }



    public function addCrop(PostImageCrop $crop): self
    {
        if (!$this->crops->contains($crop)) {
            $this->crops[] = $crop;
            $crop->setImage($this);
        }

        return $this;
    }


    public function removeCrop(PostImageCrop $crop): self
    {
        if ($this->crops->contains($crop)) {
            $this->crops->removeElement($crop);
            // set the owning side to null (unless already changed)
            if ($crop->getImage() === $this) {
                $crop->setImage(null);
            }
        }

        return $this;
    }

}
