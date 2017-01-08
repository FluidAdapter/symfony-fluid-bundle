<?php

namespace FluidAdapter\SymfonyFluidBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class FluidExtension
 * @package FluidAdapter\SymfonyFluidBundle\DependencyInjection
 * @author Christian Spoo <cs@marketing-factory.de>
 */
class FluidExtension extends Extension
{
    /**
     * Responds to the fluid configuration parameter.
     *
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../../Resources/config'));
        $loader->load('fluid.xml');
    }
}
