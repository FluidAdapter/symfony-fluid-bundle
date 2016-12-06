<?php

namespace Mfc\Symfony\Bundle\FluidBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Mfc\Symfony\Bundle\FluidBundle\DependencyInjection
 * @author Christian Spoo <cs@marketing-factory.de>
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fluid');

        $rootNode
            ->treatNullLike([
                'enabled' => true
            ])
            ->end();

        return $treeBuilder;
    }
}
