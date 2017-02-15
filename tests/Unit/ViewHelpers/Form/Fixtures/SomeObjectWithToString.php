<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Form\Fixtures;

class SomeObjectWithToString
{
    public function __toString()
    {
        return 'foobar';
    }
}