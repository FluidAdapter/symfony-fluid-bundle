<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers;

use FluidAdapter\SymfonyFluidBundle\Fluid\RenderingContext;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\FormViewHelper;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Uri\RouteViewHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInvoker;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver;

abstract class AbstractViewHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function assertViewHelperOutput($arguments, $expectedResult, $renderChildrenClosure = NULL)
    {
        if ($renderChildrenClosure === NULL) {
            $renderChildrenClosure = function(){};
        }
        $result = FormViewHelper::renderStatic(
            $arguments,
            $renderChildrenClosure,
            $this->createRendereringContext()
        );
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function createRendereringContext()
    {
        $renderingContext = $this->createMock(RenderingContext::class);
        $container = $this->createMock(ContainerInterface::class);
        $renderingContext->expects($this->any())->method('getContainer')->willReturn($container);

        $viewHelperInvoker = new ViewHelperInvoker();
        $renderingContext->expects($this->any())->method('getViewHelperInvoker')->willReturn($viewHelperInvoker);

        $viewHelperResolver = new ViewHelperResolver();
        $renderingContext->expects($this->any())->method('getViewHelperResolver')->willReturn($viewHelperResolver);

        return $renderingContext;
    }
}
