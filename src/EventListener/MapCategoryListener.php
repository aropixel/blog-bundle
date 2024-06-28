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



class MapCategoryListener implements EventSubscriber
{

    /**
     * @param string $postClass
     * @param string $categoriesMode
     */
    public function __construct(private $postClass, private $categoriesMode)
    {
    }


    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
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
