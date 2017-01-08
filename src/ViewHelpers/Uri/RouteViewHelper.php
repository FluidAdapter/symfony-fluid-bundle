<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers\Uri;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class RouteViewHelper
 * @package FluidAdapter\SymfonyFluidBundle\Fluid\ViewHelper\Routing
 * @author Christian Spoo <cs@marketing-factory.de>
 */
class RouteViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('route', 'string', 'The route name whose route should be generated', true);
        $this->registerArgument('arguments', 'array', 'The route arguments', false);
    }

    public function render()
    {
        return static::renderStatic($this->arguments, $this->buildRenderChildrenClosure(), $this->renderingContext);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $routeName = $arguments['route'];
        $routeArgs = $arguments['arguments'];

        if (!is_array($routeArgs)) {
            $routeArgs = [];
        }

        $urlGenerator = $renderingContext->getContainer()->get('router');

        return $urlGenerator->generate($routeName, $routeArgs);
    }
}
