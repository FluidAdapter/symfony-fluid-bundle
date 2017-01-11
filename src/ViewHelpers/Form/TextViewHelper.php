<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers\Form;

use Symfony\Component\Form\FormView;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 */
class TextViewHelper extends AbstractTagBasedViewHelper
{

    /**
     * Name of the tag to be created by this view helper
     *
     * @var string
     * @api
     */
    protected $tagName = 'input';

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerTagAttribute('type', 'string', 'Type to use for this input', false, 'text');
        $this->registerTagAttribute('name', 'string', 'Name to use for this form', false);
        $this->registerArgument('value', 'string', 'Value to use for this input', false, null);
    }

    /**
     * @return mixed|string
     */
    public function render()
    {
        $this->tag->addAttribute('value', $this->arguments['value']);
        return $this->tag->render();
    }
}
