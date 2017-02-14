<?php
namespace FluidAdapter\SymfonyFluidBundle;

use FluidAdapter\SymfonyFluidBundle\Fluid\RenderingContext;
use TYPO3Fluid\Fluid\View\TemplateView;

/**
 * @package FluidAdapter\SymfonyFluidBundle
 */
class TemplateViewFactory
{
    /**
     */
    public function createTemplateView($container, $templatePaths)
    {
        $templateView = new TemplateView();
        $renderingContext = new RenderingContext($templateView);
        $renderingContext->setTemplatePaths($templatePaths);
        $renderingContext->setContainer($container);
        $templateView->setRenderingContext($renderingContext);
        return $templateView;
    }
}