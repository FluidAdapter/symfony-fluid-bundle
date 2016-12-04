<?php

namespace Mfc\Symfony\Bundle\FluidBundle\ViewHelper\Routing;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class UriViewHelper
 * @package Mfc\Symfony\Bundle\Fluid\ViewHelper\Routing
 */
class UriViewHelper extends AbstractViewHelper
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function initializeArguments()
    {
        $this->registerArgument('route', 'string', 'The route name whose route should be generated', true);
        $this->registerArgument('arguments', 'array', 'The route arguments', false);
    }

    public function render()
    {
        $routeName = $this->arguments['route'];
        $arguments = $this->arguments['arguments'];
        if (!is_array($arguments)) {
            $arguments = [];
        }

        return $this->urlGenerator->generate($routeName, $arguments);
    }
}
