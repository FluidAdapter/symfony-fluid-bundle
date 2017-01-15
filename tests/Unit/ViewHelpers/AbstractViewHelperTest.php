<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers;

use FluidAdapter\SymfonyFluidBundle\Fluid\RenderingContext;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\FormViewHelper;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Uri\RouteViewHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInvoker;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperVariableContainer;

abstract class AbstractViewHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $className;

    /**
     * @var RenderingContext
     */
    protected $renderingContext;

    /**
     */
    public function setUp()
    {
        $this->setUpRenderingContext();
        $this->setUpContainer();
        $this->setUpViewHelperInvoker();
        $this->setUpViewHelperResolver();
        $this->setUpViewHelperVariableContainer();
    }

    public function setUpRenderingContext() {
        $this->renderingContext = $this->createMock(RenderingContext::class);
    }

    public function setUpContainer() {
        $container = $this->createMock(ContainerInterface::class);
        $this->renderingContext->expects($this->any())->method('getContainer')->willReturn($container);
        return $container;
    }

    public function setUpViewHelperInvoker() {
        $viewHelperInvoker = new ViewHelperInvoker();
        $this->renderingContext->expects($this->any())->method('getViewHelperInvoker')->willReturn($viewHelperInvoker);
        return $viewHelperInvoker;
    }

    public function setUpViewHelperResolver() {
        $viewHelperResolver = new ViewHelperResolver();
        $this->renderingContext->expects($this->any())->method('getViewHelperResolver')->willReturn($viewHelperResolver);
        return $viewHelperResolver;
    }

    public function setUpViewHelperVariableContainer() {
        $viewHelperVariableContainer = new ViewHelperVariableContainer();
        $this->renderingContext->expects($this->any())->method('getViewHelperVariableContainer')->willReturn($viewHelperVariableContainer);
        return $viewHelperVariableContainer;
    }

    /**
     */
    public function assertViewHelperOutput($arguments, $expectedResult, $renderChildrenClosure = NULL)
    {
        if ($renderChildrenClosure === NULL) {
            $renderChildrenClosure = function(){};
        }

        $result = call_user_func(
            array($this->className, 'renderStatic'),
            $arguments,
            $renderChildrenClosure,
            $this->renderingContext
        );
        $this->assertEquals($expectedResult, $result);
    }
}
