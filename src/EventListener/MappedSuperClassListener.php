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


class MappedSuperClassListener implements EventSubscriber
{

    /**
     * MapPageBundleSubscriber constructor.
     * @param mixed[] $entitiesNames
     */
    public function __construct(private $entitiesNames)
    {
    }


    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

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

    private function isRelation(int $type): bool
    {
        return in_array(
            $type,
            [
                ClassMetadata::MANY_TO_MANY,
                ClassMetadata::ONE_TO_MANY,
                ClassMetadata::ONE_TO_ONE,
            ],
            true
        );
    }


}
