<?php
namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers;

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */
use Symfony\Component\VarDumper\VarDumper;

/**
 *
 *
 * <code title="inline notation and custom title">
 * {object -> f:debug(title: 'Custom title')}
 * </code>
 * <output>
 * all properties of {object} nicely highlighted (with custom title)
 * </output>
 *
 * <code title="only output the type">
 * {object -> f:debug(typeOnly: true)}
 * </code>
 * <output>
 * the type or class name of {object}
 * </output>
 *
 * Note: This view helper is only meant to be used during development
 *
 * @api
 */
class DebugViewHelper extends \TYPO3Fluid\Fluid\ViewHelpers\DebugViewHelper {

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $expressionToExamine = $renderChildrenClosure();
        echo 'woot?';
        VarDumper::dump($expressionToExamine);
    }

}
