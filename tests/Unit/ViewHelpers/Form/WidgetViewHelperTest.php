<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Form;

use FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\AbstractViewHelperTest;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Form\WidgetViewHelper;
use Symfony\Component\Form\FormView;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver;
use TYPO3Fluid\Fluid\View\TemplateView;
use TYPO3Fluid\Fluid\View\ViewInterface;

class WidgetViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @var string
     */
    protected $className = WidgetViewHelper::class;

    public function setUpViewHelperVariableContainer() {
        $viewHelperVariableContainer = $this->getMockBuilder(ViewHelperVariableContainer::class)->setMethods(['getView'])->getMock();
        $this->renderingContext->expects($this->any())->method('getViewHelperVariableContainer')->willReturn($viewHelperVariableContainer);

        $view = $this->getMockBuilder(TemplateView::class)->setMethods(['renderPartial'])->getMock();
        $viewHelperVariableContainer->expects($this->any())->method('getView')->willReturn($view);

        $view->expects($this->once())->method('renderPartial')->with('Form/Text', null, array(
            'value' => null,
            'attr' => [],
            'block_prefixes' => ['form', 'text', 'form_fieldname']
        ))->willReturn('partial content');
    }

    /**
     * @test
     */
    public function simpleArgumentsBasedOutput()
    {
        $form = new FormView();
        $form->vars['block_prefixes'] = array('form', 'text', 'form_fieldname');

        $this->assertViewHelperOutput(
            [
                'item' => $form
            ],
            'partial content'
        );
    }
}
