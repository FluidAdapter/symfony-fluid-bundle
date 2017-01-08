<?php

namespace FluidAdapter\SymfonyFluidBundle\Fluid;


use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Extends the original TYPO3Fluid Rendering Context to
 * add the DI Container
 * @package Mia3\FluidBundle\Fluid\Core\Rendering
 */
class RenderingContext extends \TYPO3Fluid\Fluid\Core\Rendering\RenderingContext
{
    use ContainerAwareTrait;

    /**
     * Getter for the DI Container
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}