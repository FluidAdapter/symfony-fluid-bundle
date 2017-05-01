<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 */
class TranslateViewHelper extends AbstractViewHelper
{

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('text', 'string', 'Text to translate', false);
        $this->registerArgument('arguments', 'array', 'translation arguments', false, array());
        $this->registerArgument('domain', 'array', 'translation domain', false, null);
        $this->registerArgument('locale', 'array', 'translation locale', false, null);
    }

    /**
     * @return mixed|string
     */
    public function render()
    {
        if (empty($this->arguments['text'])) {
            $this->arguments['text'] = $this->renderChildren();
        }
        return $this->renderingContext->getContainer()->get('translator')->trans(
            $this->arguments['text'],
            $this->arguments['arguments'],
            $this->arguments['domain'],
            $this->arguments['locale']
        );
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}
