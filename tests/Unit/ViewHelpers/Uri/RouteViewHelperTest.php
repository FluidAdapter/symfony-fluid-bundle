<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Uri;

use FluidAdapter\SymfonyFluidBundle\Fluid\RenderingContext;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Uri\RouteViewHelper;
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
        $viewHelper = new RouteViewHelper();
        $viewHelper->setRenderingContext($renderingContext);
        $viewHelper->setArguments(array(
            'name' => 'someRoute',
            'arguments' => array(),
            'absolute' => false
        ));
        $generatedRoute = $viewHelper->render();
        $this->assertEquals('foo/bar', $generatedRoute);
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
