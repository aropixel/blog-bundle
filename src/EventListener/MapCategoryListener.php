<?php
/**
 * Créé par Aropixel @2019.
 * Par: Joël Gomez Caballe
 * Date: 16/04/2019 à 15:56
 */

namespace Aropixel\BlogBundle\EventListener;

use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Entity\PostInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;



/**
 * Doctrine Event Subscriber that handles the dynamic mapping of Post categories.
 *
 * Depending on the configuration (categories mode: 'category' or 'tags'), this
 * listener dynamically defines the relationship between the Post entity and
 * the PostCategory entity.
 */
class MapCategoryListener implements EventSubscriber
{

    /**
     * @param string $postClass The concrete Post entity class name.
     * @param string $categoriesMode The category mode configured ('category' or 'tags').
     */
    public function __construct(
        private string $postClass,
        private string $categoriesMode
    ) {
    }


    /**
     * Returns the events this subscriber is subscribed to.
     *
     * @return array<string>
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    /**
     * Modifies class metadata when it's loaded by Doctrine to dynamically
     * map the relation between Post and PostCategory.
     *
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {
        $metadata = $eventArgs->getClassMetadata();

        if ($metadata->getName() === $this->postClass) {
            if ($this->categoriesMode == 'category') {
                $metadata->mapManyToOne(['fieldName' => 'category', 'targetEntity' => PostCategory::class, 'inversedBy' => 'posts']);
            }
            else if ($this->categoriesMode == 'tags') {
                $metadata->mapManyToMany(['fieldName' => 'categories', 'targetEntity' => PostCategory::class, 'inversedBy' => 'posts', 'joinTable' => ['name' => 'aropixel_post_tag']]);
            }
        }

        if ($metadata->getName() === PostCategory::class) {
            if ($this->categoriesMode == 'category') {
                $metadata->mapOneToMany(['fieldName' => 'posts', 'targetEntity' => PostInterface::class, 'mappedBy' => 'category']);
            }
            else if ($this->categoriesMode == 'tags') {
                $metadata->mapManyToMany(['fieldName' => 'posts', 'targetEntity' => PostInterface::class, 'mappedBy' => 'categories']);
            }
        }

    }


}
