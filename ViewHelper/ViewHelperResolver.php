<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelper;

use FluidAdapter\SymfonyFluidBundle\ViewHelper\Uri\RouteViewHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolver as BaseViewHelperResolver;

/**
 * Class ViewHelperResolver
 * @package FluidAdapter\SymfonyFluidBundle\ViewHelper
 * @author Christian Spoo <cs@marketing-factory.de>
 */
class ViewHelperResolver extends BaseViewHelperResolver
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function resolveViewHelperClassName($namespaceIdentifier, $methodIdentifier)
    {
        if ($namespaceIdentifier === 'f') {
            switch ($methodIdentifier) {
                case 'uri.route':
                    return RouteViewHelper::class;
            }
        }

        return parent::resolveViewHelperClassName($namespaceIdentifier, $methodIdentifier);
    }
}
