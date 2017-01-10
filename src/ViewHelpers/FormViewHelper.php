<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers;

use Symfony\Component\Form\FormView;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 */
class FormViewHelper extends AbstractTagBasedViewHelper
{

    /**
     * Name of the tag to be created by this view helper
     *
     * @var string
     * @api
     */
    protected $tagName = 'form';

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerTagAttribute('name', 'string', 'Name to use for this form', false);
        $this->registerTagAttribute('action', 'string', 'Action to use for this form', false);
        $this->registerTagAttribute('method', 'string', 'Name to use for this form', false, 'get');
        $this->registerArgument('form', FormView::class, 'FormVIew to use for this form', false);
    }

    /**
     * Sets the tag name to $this->tagName.
     * Additionally, sets all tag attributes which were registered in
     * $this->tagAttributes and additionalArguments.
     *
     * Will be invoked just before the render method.
     *
     * @return void
     * @api
     */
    public function initialize()
    {
        if (isset($this->arguments['form'])) {
            $this->arguments = array_replace(
                $this->arguments,
                $this->arguments['form']->vars
            );
        }
        parent::initialize();
    }

    /**
     * @return mixed|string
     */
    public function render()
    {
        $this->tag->setContent($this->renderChildren());

        return $this->tag->render();
    }
}
