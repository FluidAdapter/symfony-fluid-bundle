<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers;

use FluidAdapter\SymfonyFluidBundle\Fluid\RenderingContext;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class FlashMessagesViewHelper extends AbstractViewHelper
{

    /**
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @var RenderingContext
     */
    protected $renderingContext;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('class', 'string', 'class to apply to all flash messages', false, 'alert');
    }

    /**
     * @return mixed|string
     */
    public function render()
    {
        $flashMessages = $this->getFlashMessages();

        if ($this->templateVariableContainer->exists('flashMessages')) {
            $backupFlashMessages = $this->templateVariableContainer->get('flashMessages');
            $this->templateVariableContainer->remove('flashMessages');
        }
        $this->templateVariableContainer->add('flashMessages', $flashMessages);
        $output = $this->renderChildren();
        $this->templateVariableContainer->remove('flashMessages');
        if (isset($backupFlashMessages)) {
            $this->templateVariableContainer->add('flashMessages', $backupFlashMessages);
        }

        if (!empty($output)) {
            return $output;
        }

        return $this->viewHelperVariableContainer
            ->getView()
            ->renderPartial(
                'FlashMessages',
                null,
                [
                    'flashMessages' => $flashMessages,
                ]
            );
    }

    public function getFlashMessages()
    {
        $flashMessages = [];
        $flashBag = $this->renderingContext->getRequest()->getSession()->getFlashBag();
        foreach ($flashBag->all() as $flashMessageType => $flashMessageGroup) {
            foreach ($flashMessageGroup as $flashMessage) {
                $class = $this->arguments['class'] . ' ' . $this->arguments['class'] . '-' . $flashMessageType;
                $flashMessages[] = array(
                    'type' => $flashMessageType,
                    'message' => $flashMessage,
                    'class' => $class
                );
            }
        }

        return $flashMessages;
    }
}
