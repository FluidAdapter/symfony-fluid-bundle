<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Form;

use FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\AbstractViewHelperTest;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Form\RadioViewHelper;

class RadioViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @var string
     */
    protected $className = RadioViewHelper::class;

    /**
     * @test
     */
    public function simpleArgumentsBasedOutput()
    {
        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'value' => 'foo'
            ],
            '<input type="hidden" name="some-name" value="" /><input type="radio" name="some-name" value="foo" />'
        );

        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'value' => 'foo',
                'checked' => true
            ],
            '<input type="hidden" name="some-name" value="" /><input type="radio" name="some-name" value="foo" checked="checked" />'
        );

        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'value' => 'foo',
                'disabled' => true
            ],
            '<input type="hidden" name="some-name" value="" /><input disabled="1" type="radio" name="some-name" value="foo" />'
        );
    }
}
