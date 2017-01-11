<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers\Form;

use Symfony\Component\Form\FormView;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 */
class WidgetViewHelper extends AbstractViewHelper
{
    /**
     * @var boolean
     */
    protected $escapeOutput = false;

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
        $item = $this->arguments['item'];
        $partial = $this->getPartial($item);
        $partialArguments = $item->vars;
        return $this->viewHelperVariableContainer->getView()->renderPartial($partial, NULL, $partialArguments);
    }

    public function getPartial($item) {
        $prefixes = array_slice($item->vars['block_prefixes'], 0, -1);
        array_walk($prefixes, function(&$prefix) {
            $prefix = ucfirst($prefix);
        });
        return implode('/', $prefixes);
    }
}
