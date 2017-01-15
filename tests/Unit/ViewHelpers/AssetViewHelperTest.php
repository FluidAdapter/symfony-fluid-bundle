<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers;

use FluidAdapter\SymfonyFluidBundle\Fluid\RenderingContext;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\AssetViewHelper;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\FormViewHelper;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Uri\RouteViewHelper;
use Symfony\Component\Asset\Packages;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInvoker;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver;

class AssetViewHelperTest extends AbstractViewHelperTest
{

    /**
     * @var string
     */
    protected $className = AssetViewHelper::class;

    public function setUpContainer() {
        $container = parent::setUpContainer();
        $packages = $this->createMock(Packages::class);
        $packages->expects($this->any())->method('getUrl')->willReturn('/some/path/asset.css');
        $container->expects($this->any())->method('get')->willReturn($packages);
        return $container;
    }

    /**
     * @test
     */
    public function simpleArgumentsBasedOutput()
    {
        $this->assertViewHelperOutput(
            [
                'path' => 'path/asset.css'
            ],
            '/some/path/asset.css'
        );

    }

}
