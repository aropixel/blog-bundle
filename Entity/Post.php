<?php

namespace Aropixel\BlogBundle\Entity;

use Aropixel\AdminBundle\Entity\Publishable;
use Aropixel\AdminBundle\Entity\PublishableTrait;
use Aropixel\BlogBundle\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


#[ORM\Table(name: "aropixel_post")]
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post implements PostInterface
{

    use PublishableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private string $status = Publishable::STATUS_OFFLINE;

    #[ORM\Column(nullable: true)]
    private ?string $title = null;

    #[Gedmo\Slug(fields: ["title"])]
    #[ORM\Column]
    private string $slug;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $excerpt = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?string $metaTitle = null;

    #[ORM\Column(nullable: true)]
    private ?string $metaDescription = null;

    #[ORM\Column(nullable: true)]
    private ?string $metaKeywords = null;

    #[ORM\OneToOne(targetEntity: \Aropixel\BlogBundle\Entity\PostImage::class, inversedBy: "post", cascade: ["persist", "remove"])]
    #[ORM\JoinColumn(name: "image_id", onDelete: "SET NULL")]
    private ?PostImage $image = null;

    #[Gedmo\Timestampable(on: "create")]
    #[ORM\Column(name: "created_at", type: "datetime", nullable: true)]
    private ?\DateTime $createdAt = null;

    #[Gedmo\Timestampable(on: "update")]
    #[ORM\Column(name: "updated_at", type: "datetime", nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $publishAt = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $publishUntil = null;

    /**
     * @var Collection|PostCategory[]
     */
    #[ORM\ManyToMany(targetEntity: "PostCategory", inversedBy: "posts")]
    #[ORM\JoinTable(name: "post_categories")]
    private Collection $categories;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
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
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(PostCategory $tag): self
    {
        if (!$this->categories->contains($tag)) {
            $this->categories[] = $tag;
        }

        return $this;
    }

    public function removeCategory(PostCategory $tag): self
    {
        if ($this->categories->contains($tag)) {
            $this->categories->removeElement($tag);
        }

        return $this;
    }

}
