<?php
/**
 * Créé par Aropixel @2019.
 * Par: Joël Gomez Caballe
 * Date: 16/04/2019 à 15:56
 */

namespace Aropixel\BlogBundle\EventListener;

use Aropixel\BlogBundle\Entity\PostCategory;
use Aropixel\BlogBundle\Entity\PostInterface;
use Aropixel\MenuBundle\Entity\Menu;
use Aropixel\PageBundle\Entity\Page;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataInfo;



class MapCategorySubscriber implements EventSubscriber
{

    /** @var string */
    private $postClass;

    /** @var string */
    private $categoriesMode;


    public function __construct($postClass, $categoriesMode)
    {
        $this->postClass = $postClass;
        $this->categoriesMode = $categoriesMode;
    }


    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {

        /** @var ClassMetadataInfo $metadata */
        $metadata = $eventArgs->getClassMetadata();

        if ($metadata->getName() === $this->postClass) {

            if ($this->categoriesMode == 'category') {

                $metadata->mapManyToOne(array(
                    'fieldName' => 'category',
                    'targetEntity' => PostCategory::class,
                    'inversedBy' => 'posts'
                ));

            }
            else if ($this->categoriesMode == 'tags') {

                $metadata->mapManyToMany(array(
                    'fieldName' => 'categories',
                    'targetEntity' => PostCategory::class,
                    'inversedBy' => 'posts',
                    'joinTable' => array('name' => 'aropixel_post_tag')
                ));

            }

        }

        if ($metadata->getName() === PostCategory::class) {

            if ($this->categoriesMode == 'category') {

                $metadata->mapOneToMany(array(
                    'fieldName' => 'posts',
                    'targetEntity' => PostInterface::class,
                    'mappedBy' => 'category'
                ));

            }
            else if ($this->categoriesMode == 'tags') {

                $metadata->mapManyToMany(array(
                    'fieldName' => 'posts',
                    'targetEntity' => PostInterface::class,
                    'mappedBy' => 'categories',
                ));

            }

        }


    }


}
