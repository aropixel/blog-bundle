<?php
/**
 * Créé par Aropixel @2019.
 * Par: Joël Gomez Caballe
 * Date: 16/04/2019 à 15:56
 */

namespace Aropixel\BlogBundle\EventListener;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;


/**
 * Doctrine Event Subscriber that handles the conversion of MappedSuperclasses to Entities.
 *
 * This listener checks if a class being loaded is configured as a customized entity.
 * If so, and if it's marked as a MappedSuperclass, it unsets that flag so Doctrine
 * treats it as a regular entity. This allows the bundle's base entities to be
 * extended and replaced by the application.
 */
class MappedSuperClassListener implements EventSubscriber
{

    /**
     * @param array<string,string> $entitiesNames List of entity interfaces and their concrete implementations.
     */
    public function __construct(private array $entitiesNames)
    {
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
