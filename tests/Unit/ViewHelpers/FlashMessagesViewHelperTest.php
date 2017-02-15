<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers;

use FluidAdapter\SymfonyFluidBundle\Fluid\RenderingContext;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\FlashMessagesViewHelper;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\FormViewHelper;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Uri\RouteViewHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use TYPO3Fluid\Fluid\Core\Variables\StandardVariableProvider;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInvoker;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver;

class FlashMessagesViewHelperTest extends AbstractViewHelperTest
{

    /**
     * @var string
     */
    protected $className = FlashMessagesViewHelper::class;

    public function setUpViewHelperVariableContainer() {
        $flashBag = $this->createMock(FlashBag::class);
        $flashBag->expects($this->once())->method('all')->willReturn([
            'notice' => [
                'some message'
            ]
        ]);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())->method('getFlashBag')->willReturn($flashBag);

        $request = $this->createMock(Request::class);
        $request->expects($this->once())->method('getSession')->willReturn($session);

        $this->renderingContext->expects($this->any())->method('getRequest')->willReturn($request);

        $variableProvider = new StandardVariableProvider(['flashMessages' => []]);
        $this->renderingContext->expects($this->any())->method('getVariableProvider')->willReturn($variableProvider);

        $viewHelperVariableContainer = $this->getMockBuilder(ViewHelperVariableContainer::class)->setMethods(['getView'])->getMock();
        $this->renderingContext->expects($this->any())->method('getViewHelperVariableContainer')->willReturn($viewHelperVariableContainer);

        $view = $this->getMockBuilder(TemplateView::class)->setMethods(['renderPartial'])->getMock();
        $viewHelperVariableContainer->expects($this->any())->method('getView')->willReturn($view);

        $view->expects($this->any())->method('renderPartial')->willReturn('<div class="alert alert-notice">some message</div>');
    }

    /**
     * @test
     */
    public function simpleArgumentsBasedOutput()
    {
        $this->assertViewHelperOutput(
            [],
            '<div class="alert alert-notice">some message</div>'
        );
    }
}
