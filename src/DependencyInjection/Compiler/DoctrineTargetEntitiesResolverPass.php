<?php

namespace Aropixel\BlogBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Compiler pass to automatically register resolve_target_entity mappings.
 *
 * It reads the 'aropixel_blog.entities' parameter and adds the corresponding
 * resolveTargetEntity mappings to the Doctrine ResolveTargetEntityListener.
 */
class DoctrineTargetEntitiesResolverPass implements CompilerPassInterface
{
    /**
     * Process the compiler pass to configure resolve_target_entity mappings.
     */
    public function process(ContainerBuilder $container): void
    {
        try {
            $resolveTargetEntityListener = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');
        } catch (InvalidArgumentException) {
            return;
        }

        $entities = $container->getParameter('aropixel_blog.entities');
        foreach ($entities as $interface => $model) {
            $resolveTargetEntityListener->addMethodCall('addResolveTargetEntity', [$interface, $model, []]);
        }

        if (!$resolveTargetEntityListener->hasTag('doctrine.event_listener')) {
            $resolveTargetEntityListener->addTag('doctrine.event_listener', ['event' => 'loadClassMetadata']);
        }
    }
}
