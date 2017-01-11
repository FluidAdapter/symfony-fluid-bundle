<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers\Form;

use Symfony\Component\Form\FormView;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 */
class LabelViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'label';

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('item', FormView::class, 'Item to render', true);
    }

    /**
     * @return mixed|string
     */
    public function render()
    {
        $arguments = $this->arguments['item']->vars;
        $this->tag->addAttribute('for', $arguments['id']);
        $this->tag->setContent($arguments['label']);
        return $this->tag->render();
    }
}
