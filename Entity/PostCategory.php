<?php

namespace Aropixel\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Category
 *
 * @ORM\Table(name="post_category")
 * @ORM\Entity(repositoryClass="Aropixel\BlogBundle\Repository\PostCategoryRepository")
 */
class PostCategory
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Post[]
     */
    private $categoryPosts;

    /**
     * @var Post[]
     */
    private $tagPosts;



    public function __construct()
    {
        $this->categoryPosts = new ArrayCollection();
        $this->tagPosts = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return self
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    /**
     * @return Collection|Post[]
     */
    public function getCategoryPosts(): Collection
    {
        return $this->categoryPosts;
    }


    public function addCategoryPost(Post $categoryPost): self
    {
        if (!$this->categoryPosts->contains($categoryPost)) {
            $this->categoryPosts[] = $categoryPost;
            $categoryPost->setCategory($this);
        }

        return $this;
    }


    public function removeCategoryPost(Post $categoryPost): self
    {
        if ($this->categoryPosts->contains($categoryPost)) {
            $this->categoryPosts->removeElement($categoryPost);
            // set the owning side to null (unless already changed)
            if ($categoryPost->getCategory() === $this) {
                $categoryPost->setCategory(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection|Post[]
     */
    public function getTagPosts(): Collection
    {
        return $this->tagPosts;
    }


    public function addTagPost(Post $tagPost): self
    {
        if (!$this->tagPosts->contains($tagPost)) {
            $this->tagPosts[] = $tagPost;
            $tagPost->addTag($this);
        }

        return $this;
    }


    public function removeTagPost(Post $tagPost): self
    {
        if ($this->tagPosts->contains($tagPost)) {
            $this->tagPosts->removeElement($tagPost);
            $tagPost->removeTag($this);
        }

        return $this;
    }



}
