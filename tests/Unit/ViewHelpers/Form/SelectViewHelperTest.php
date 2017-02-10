<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Form;

use FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\AbstractViewHelperTest;
use FluidAdapter\SymfonyFluidBundle\ViewHelpers\Form\SelectViewHelper;

class SelectViewHelperTest extends AbstractViewHelperTest
{
    /**
     * @var string
     */
    protected $className = SelectViewHelper::class;

    /**
     * @test
     */
    public function simpleArgumentsBasedOutput()
    {
        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'value' => '',
                'options' => [
                    'foo' => 'bar'
                ]
            ],
            '<input type="hidden" name="some-name" value="" />
<select name="some-name">
	<option value="foo">bar</option>
</select>'
        );

        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'value' => 'foo',
                'options' => [
                    'foo' => 'bar'
                ]
            ],
            '<input type="hidden" name="some-name" value="" />
<select name="some-name">
	<option value="foo" selected="selected">bar</option>
</select>'
        );
    }
}
