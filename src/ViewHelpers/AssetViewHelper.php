<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers;

use Symfony\Component\Asset\Packages;
use Symfony\Component\Form\FormView;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 */
class AssetViewHelper extends AbstractViewHelper
{

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('path', 'string', 'Path to the asset');
        $this->registerArgument('package', 'string', 'package name', false, null);
    }

    /**
     * @return mixed|string
     */
    public function render()
    {
        $packages = $this->renderingContext->getContainer()->get('assets.packages');
        return $packages->getUrl($this->arguments['path'], $this->arguments['package']);
    }
}
