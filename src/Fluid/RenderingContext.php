<?php

namespace FluidAdapter\SymfonyFluidBundle\Fluid;


use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Extends the original TYPO3Fluid Rendering Context to
 * add the DI Container
 * @package Mia3\FluidBundle\Fluid\Core\Rendering
 */
class RenderingContext extends \TYPO3Fluid\Fluid\Core\Rendering\RenderingContext
{
    use ContainerAwareTrait;

    /**
     * Constructor
     *
     * Constructing a RenderingContext should result in an object containing instances
     * in all properties of the object. Subclassing RenderingContext allows changing the
     * types of instances that are created.
     *
     * Setters are used to fill the object instances. Some setters will call the
     * setRenderingContext() method (convention name) to provide the instance that is
     * created with an instance of the "parent" RenderingContext.
     */
    public function __construct(ViewInterface $view)
    {
        parent::__construct($view);

        $this->viewHelperResolver->addNamespace('f', 'FluidAdapter\SymfonyFluidBundle\ViewHelpers');
    }

    /**
     * Getter for the DI Container
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function __sleep() {
        return [];
    }

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->container->get('request_stack')->getCurrentRequest();
    }
}