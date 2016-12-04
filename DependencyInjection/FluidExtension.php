<?php

namespace Mfc\Symfony\Bundle\FluidBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class FluidExtension
 * @package Mfc\Symfony\Bundle\FluidBundle\DependencyInjection
 */
class FluidExtension extends Extension
{
    /**
     * Responds to the fluid configuration parameter.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('fluid.xml');
        $loader->load('viewhelper-uri.xml');
    }
}
