<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers;

use FluidAdapter\SymfonyFluidBundle\Fluid\RenderingContext;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\FormViewHelper;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Uri\RouteViewHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInvoker;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver;

class FormViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @test
     */
    public function simpleArgumentsBasedOutput()
    {
        $this->assertViewHelperOutput(
            [],
            '<form method="get" />'
        );

        $this->assertViewHelperOutput(
            [
                'name' => 'some-name',
                'action' => 'some-action',
                'method' => 'post',
            ],
            '<form name="some-name" action="some-action" method="post" />'
        );

        $this->assertViewHelperOutput(
            [
                'name' => 'some-name',
                'action' => 'some-action',
                'method' => 'post',
            ],
            '<form name="some-name" action="some-action" method="post">some content inside the form</form>',
            function () {
                return 'some content inside the form';
            }
        );
    }

    /**
     * @test
     */
    public function formViewDrivenOutput()
    {
        $form = new FormView();
        $form->vars['method'] = "post";
        $form->vars['action'] = "form-action";
        $form->vars['name'] = "form-name";

        $this->assertViewHelperOutput(
            [
                'form' => $form
            ],
            '<form name="form-name" action="form-action" method="post">some content inside the form</form>',
            function () {
                return 'some content inside the form';
            }
        );
    }
}
