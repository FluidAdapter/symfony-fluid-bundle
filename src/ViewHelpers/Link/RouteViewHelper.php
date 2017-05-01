<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers\Link;

use Symfony\Component\Routing\Router;
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
        $this->registerArgument('absolute', 'boolean', 'Generate a absolute url including domain', false, false);
        $this->registerArgument('section', 'string', 'The anchor to be added to the URI.', false);
    }

    /**
     * @return mixed|string
     */
    public function render()
    {
        $urlGenerator = $this->renderingContext->getContainer()->get('router');

        if ($this->arguments['absolute']) {
            $url = $urlGenerator->generate(
                $this->arguments['name'],
                $this->arguments['arguments'],
                Router::ABSOLUTE_URL
            );
        } else {
            $url = $urlGenerator->generate(
                $this->arguments['name'],
                $this->arguments['arguments']
            );
        }

        if (!empty($this->arguments['section'])) {
            $url = $url . '#' . $this->arguments['section'];
        }

        $this->tag->setContent($this->renderChildren());
        $this->tag->addAttribute('href', $url);

        return $this->tag->render();
    }
}
