<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Form;

use FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\AbstractViewHelperTest;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Form\LabelViewHelper;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Form\RadioViewHelper;
use Symfony\Component\Form\FormView;

class LabelViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @var string
     */
    protected $className = LabelViewHelper::class;

    /**
     * @test
     */
    public function testWithoutSpecificLabelOutput()
    {
        $formView = new FormView();
        $formView->vars['name'] = 'someName';
        $formView->vars['id'] = 'someId';
        $this->assertViewHelperOutput(
            [
                'item' => $formView
            ],
            '<label for="someId">Some name</label>'
        );
    }

    /**
     * @test
     */
    public function testWithSpecificLabelOutput()
    {
        $formView = new FormView();
        $formView->vars['name'] = 'someName';
        $formView->vars['label'] = 'Some Label';
        $formView->vars['id'] = 'someId';
        $this->assertViewHelperOutput(
            [
                'item' => $formView
            ],
            '<label for="someId">Some Label</label>'
        );
    }
}
