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
        $this->registerArgument('name', 'string', 'The route name whose route should be generated', true);
        $this->registerArgument('arguments', 'array', 'The route arguments', false);
    }

    public function render()
    {
        $urlGenerator = $this->renderingContext->getContainer()->get('router');
        return $urlGenerator->generate(
            $this->arguments['name'],
            $this->arguments['arguments']
        );
    }
}
