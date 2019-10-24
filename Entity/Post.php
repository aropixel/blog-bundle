<?php

namespace Aropixel\BlogBundle\Entity;

use Aropixel\AdminBundle\Entity\Publishable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * Post
 */
class Post implements PostInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $status = Publishable::STATUS_OFFLINE;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $excerpt;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $metaTitle;

    /**
     * @var string
     */
    private $metaDescription;

    /**
     * @var string
     */
    private $metaKeywords;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var ?\DateTime
     */
    private $updatedAt;

    /**
     * @var ?\DateTime
     */
    private $publishAt;

    /**
     * @var ?\DateTime
     */
    private $publishUntil;

    /**
     * @var PostImage
     */
    private $image;

    /**
     * @var PostCategory
     */
    private $category;

    /**
     * @var PostCategory[]
     */
    private $tags;



    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(?string $excerpt): self
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(?string $metaTitle): self
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(?string $metaKeywords): self
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPublishAt(): ?\DateTimeInterface
    {
        return $this->publishAt;
    }

    public function setPublishAt(?\DateTimeInterface $publishAt): self
    {
        $this->publishAt = $publishAt;

        return $this;
    }

    public function getPublishUntil(): ?\DateTimeInterface
    {
        return $this->publishUntil;
    }

    public function setPublishUntil(?\DateTimeInterface $publishUntil): self
    {
        $this->publishUntil = $publishUntil;

        return $this;
    }

    public function getImage(): ?PostImage
    {
        return $this->image;
    }

    public function setImage(?PostImage $image): self
    {
        if ($image->getImage()) {
            $this->image = $image;
            $this->image->setPost($this);
        }

        return $this;
    }

    public function getCategory(): ?PostCategory
    {
        return $this->category;
    }

    public function setCategory(?PostCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|PostCategory[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(PostCategory $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(PostCategory $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

}
