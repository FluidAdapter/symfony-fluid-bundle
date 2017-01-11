<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Form;

use FluidAdapter\SymfonyFluidBundle\Fluid\RenderingContext;
use FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\AbstractViewHelperTest;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\FormViewHelper;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Form\TextViewHelper;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Uri\RouteViewHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInvoker;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver;

class TextViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @var string
     */
    protected $className = TextViewHelper::class;

    /**
     * @test
     */
    public function simpleArgumentsBasedOutput()
    {
        $this->assertViewHelperOutput(
            [],
            '<input type="text" value="" />'
        );

        $this->assertViewHelperOutput(
            [
                'name' => 'some-input',
                'value' => 'some value'
            ],
            '<input type="text" name="some-input" value="some value" />'
        );
    }
}
