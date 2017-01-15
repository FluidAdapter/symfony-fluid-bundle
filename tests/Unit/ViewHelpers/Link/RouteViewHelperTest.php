<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Link;

use FluidAdapter\SymfonyFluidBundle\Fluid\RenderingContext;
use FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\AbstractViewHelperTest;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Link\RouteViewHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RouteViewHelperTest extends AbstractViewHelperTest
{

    /**
     * @var string
     */
    protected $className = RouteViewHelper::class;

    public function setUpContainer() {
        $container = parent::setUpContainer();
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $urlGenerator->expects($this->any())->method('generate')->willReturn('foo/bar');
        $container->expects($this->any())->method('get')->willReturn($urlGenerator);
        return $container;
    }

    /**
     * @test
     */
    public function simpleArgumentsBasedOutput()
    {
        $this->assertViewHelperOutput(
            [
                'name' => 'someRoute',
                'arguments' => array(),
            ],
            '<a href="foo/bar">link text</a>',
            function() {
                return 'link text';
            }
        );

        $this->assertViewHelperOutput(
            [
                'name' => 'someRoute',
                'arguments' => array(),
                'class' => 'foo-bar'
            ],
            '<a class="foo-bar" href="foo/bar">link text</a>',
            function() {
                return 'link text';
            }
        );
    }

}
