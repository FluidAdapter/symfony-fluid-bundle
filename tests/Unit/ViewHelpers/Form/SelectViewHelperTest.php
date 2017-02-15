<?php

namespace FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Form;

use FluidAdapter\SymfonyFluidBundle\Error\Form\InvalidOptionsException;
use FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\AbstractViewHelperTest;
use FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Form\Fixtures\SomeObject;
use FluidAdapter\SymfonyFluidBundle\Tests\Unit\ViewHelpers\Form\Fixtures\SomeObjectWithToString;
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
                    'foo' => 'bar',
                    'hello' => 'world',
                ],
            ],
            '<input type="hidden" name="some-name" value="" />
<select name="some-name">
	<option value="foo">bar</option>
	<option value="hello">world</option>
</select>'
        );

        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'value' => 'foo',
                'options' => [
                    'foo' => 'bar',
                ],
            ],
            '<input type="hidden" name="some-name" value="" />
<select name="some-name">
	<option value="foo" selected="selected">bar</option>
</select>'
        );
    }

    /**
     * @test
     */
    public function renderMultiSelect()
    {
        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'value' => '',
                'multiple' => true,
                'options' => [
                    'foo' => 'bar',
                ],
            ],
            '<input type="hidden" name="some-name[]" value="" />
<select multiple="multiple" name="some-name[]">
	<option value="foo">bar</option>
</select>'
        );

        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'value' => array(
                    'foo'
                ),
                'multiple' => true,
                'options' => [
                    'foo' => 'bar',
                    'hello' => 'world'
                ],
            ],
            '<input type="hidden" name="some-name[]" value="" />
<select multiple="multiple" name="some-name[]">
	<option value="foo" selected="selected">bar</option>
	<option value="hello">world</option>
</select>'
        );

        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'selectAllByDefault' => true,
                'multiple' => true,
                'options' => [
                    'foo' => 'bar',
                ],
            ],
            '<input type="hidden" name="some-name[]" value="" />
<select multiple="multiple" name="some-name[]">
	<option value="foo" selected="selected">bar</option>
</select>'
        );
    }

    /**
     * @test
     */
    public function renderPrependOptionLabelSelect()
    {
        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'prependOptionLabel' => 'prepended label',
                'prependOptionValue' => 'prepended value',
                'options' => [
                    'foo' => 'bar',
                ]
            ],
            '<input type="hidden" name="some-name" value="" />
<select name="some-name">
	<option value="prepended value">prepended label</option>
	<option value="foo">bar</option>
</select>'
        );
    }

    /**
     * @test
     */
    public function invalidOptionsProvided()
    {
        $this->expectException(InvalidOptionsException::class);
        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'options' => 'foobar'
            ],
            ''
        );
    }

    /**
     * @test
     */
    public function someObjectWithoutToStringObject()
    {
        $someObject = new SomeObject();
        $this->expectException(InvalidOptionsException::class);
        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'options' => array(
                    $someObject
                )
            ],
            ''
        );
    }

    /**
     * @test
     */
    public function someObjectWithToStringObject()
    {
        $someObject = new SomeObjectWithToString();
        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'options' => array(
                    $someObject
                )
            ],
            '<input type="hidden" name="some-name" value="" />
<select name="some-name">
	<option value="foobar">foobar</option>
</select>'
        );
    }

    /**
     * @test
     */
    public function sortByLabels()
    {
        $this->assertViewHelperOutput(
            [
                'name' => "some-name",
                'sortByOptionLabel' => true,
                'options' => array(
                    'b' => 'b',
                    'c' => 'c',
                    'a' => 'a'
                )
            ],
            '<input type="hidden" name="some-name" value="" />
<select name="some-name">
	<option value="a">a</option>
	<option value="b">b</option>
	<option value="c">c</option>
</select>'
        );
    }
}

