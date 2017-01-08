<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Link;

use FluidAdapter\SymfonyFluidBundle\Fluid\RenderingContext;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Link\RouteViewHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RouteViewHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function basicRouteIsGenerated()
    {
        $renderingContext = $this->createRendereringContextThatReturnsUrlGeneratorWithRoute('foo/bar');
        $viewHelper = $this->getMockBuilder(RouteViewHelper::class)
            ->setMethods(['renderChildren'])
            ->getMock();
        $viewHelper->expects($this->once())->method('renderChildren')->willReturn('link text');
        $viewHelper->setRenderingContext($renderingContext);
        $viewHelper->setArguments(array(
            'name' => 'someRoute',
            'arguments' => array(),
        ));
        $generatedRoute = $viewHelper->render();
        $this->assertEquals('<a href="foo/bar">link text</a>', $generatedRoute);
    }

    /**
     * @param $route
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function createRendereringContextThatReturnsUrlGeneratorWithRoute($route)
    {
        $renderingContext = $this->createMock(RenderingContext::class);
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $urlGenerator->expects($this->once())->method('generate')->willReturn($route);
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->once())->method('get')->willReturn($urlGenerator);
        $renderingContext->expects($this->once())->method('getContainer')->willReturn($container);

        return $renderingContext;
    }
}
