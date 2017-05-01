<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers\Uri;

use Symfony\Component\Routing\Router;
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
        $this->registerArgument('arguments', 'array', 'The route arguments', false, array());
        $this->registerArgument('absolute', 'boolean', 'Generate a absolute url including domain', false, false);
        $this->registerArgument('section', 'string', 'The anchor to be added to the URI.', false);
    }

    public function render()
    {
        $urlGenerator = $this->renderingContext->getContainer()->get('router');
        if ($this->arguments['absolute']) {
            $uri = $urlGenerator->generate(
                $this->arguments['name'],
                $this->arguments['arguments'],
                Router::ABSOLUTE_URL
            );
        } else {
            $uri = $urlGenerator->generate(
                $this->arguments['name'],
                $this->arguments['arguments']
            );
        }

        if (!empty($this->arguments['section'])) {
            $uri = $uri . '#' . $this->arguments['section'];
        }

        return $uri;
    }
}
