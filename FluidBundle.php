<?php

namespace Mfc\Symfony\Bundle\FluidBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class FluidBundle
 * @package Mfc\Symfony\Fluid
 */
class FluidBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
