<?php
/**
 * Créé par Aropixel @2019.
 * Par: Joël Gomez Caballe
 * Date: 16/04/2019 à 15:56
 */

namespace Aropixel\BlogBundle\EventListener;


use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * Doctrine Event Listener that handles the conversion of MappedSuperclasses to Entities.
 *
 * This listener checks if a class being loaded is configured as a customized entity.
 * If so, and if it's marked as a MappedSuperclass, it unsets that flag so Doctrine
 * treats it as a regular entity. This allows the bundle's base entities to be
 * extended and replaced by the application.
 */
#[AsDoctrineListener(event: Events::loadClassMetadata, priority: 8192)]
class MappedSuperClassListener
{

    /**
     * @param array<string,string> $entitiesNames List of entity interfaces and their concrete implementations.
     */
    public function __construct(
        #[Autowire('%aropixel_blog.entities%')]
        private readonly array $entitiesNames
    ) {
    }

    /**
     * Modifies class metadata when it's loaded by Doctrine.
     *
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs): void
    {

        $metadata = $eventArgs->getClassMetadata();

        /**
         * Check if the reflection class is part of the customized entities
         */
        foreach ($this->entitiesNames as $interface => $model) {
            if ($metadata->getName() == $model) {
                if ($metadata->isMappedSuperclass) {
                    $metadata->isMappedSuperclass = false;
                }
            }
        }

    }

}
