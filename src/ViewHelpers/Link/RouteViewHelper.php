<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers\Link;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class RouteViewHelper
 * @package FluidAdapter\SymfonyFluidBundle\Fluid\ViewHelper\Routing
 */
class RouteViewHelper extends AbstractTagBasedViewHelper
{

    /**
     * Name of the tag to be created by this view helper
     *
     * @var string
     * @api
     */
    protected $tagName = 'a';

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('name', 'string', 'The route name whose route should be generated', true);
        $this->registerArgument('arguments', 'array', 'The route arguments', false, array());
        $this->registerTagAttribute('class', 'string', 'tag classes');
    }

    /**
     * @return mixed|string
     */
    public function render()
    {
        $urlGenerator = $this->renderingContext->getContainer()->get('router');

        $this->tag->setContent($this->renderChildren());
        $this->tag->addAttribute('href', $urlGenerator->generate(
            $this->arguments['name'],
            $this->arguments['arguments']
        ));

        return $this->tag->render();
    }
}
