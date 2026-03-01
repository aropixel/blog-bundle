<?php

namespace Aropixel\BlogBundle\EventListener;

use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Entity\PostInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * Doctrine Event Listener that handles the dynamic mapping of Post categories.
 *
 * Depending on the configuration (categories mode: 'category' or 'tags'), this
 * listener dynamically defines the relationship between the Post entity and
 * the PostCategory entity.
 */
#[AsDoctrineListener(event: Events::loadClassMetadata)]
class MapCategoryListener
{
    /**
     * @param string $postClass      the concrete Post entity class name
     * @param string $categoriesMode the category mode configured ('category' or 'tags')
     */
    public function __construct(
        #[Autowire('%aropixel_blog.entities.post%')]
        private readonly string $postClass,
        #[Autowire('%aropixel_blog.categories%')]
        private readonly string $categoriesMode
    ) {
    }

    /**
     * Modifies class metadata when it's loaded by Doctrine to dynamically
     * map the relation between Post and PostCategory.
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $metadata = $eventArgs->getClassMetadata();

        if ($metadata->getName() === $this->postClass) {
            if ('category' == $this->categoriesMode) {
                $metadata->mapManyToOne(['fieldName' => 'category', 'targetEntity' => PostCategory::class, 'inversedBy' => 'posts']);
            } elseif ('tags' == $this->categoriesMode) {
                $metadata->mapManyToMany(['fieldName' => 'categories', 'targetEntity' => PostCategory::class, 'inversedBy' => 'posts', 'joinTable' => ['name' => 'aropixel_post_tag']]);
            }
        }

        if (PostCategory::class === $metadata->getName()) {
            if ('category' == $this->categoriesMode) {
                $metadata->mapOneToMany(['fieldName' => 'posts', 'targetEntity' => PostInterface::class, 'mappedBy' => 'category']);
            } elseif ('tags' == $this->categoriesMode) {
                $metadata->mapManyToMany(['fieldName' => 'posts', 'targetEntity' => PostInterface::class, 'mappedBy' => 'categories']);
            }
        }
    }
}
