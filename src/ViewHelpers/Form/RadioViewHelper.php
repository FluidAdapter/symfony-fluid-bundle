<?php

namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers\Form;

/**
 * View Helper which creates a simple checkbox (<input type="checkbox">).
 *
 * = Examples =
 *
 * <code title="Example">
 * <f:form.radio name="myRadio" value="someValue" />
 * </code>
 * <output>
 * <input type="radio" name="myRadio" value="someValue" />
 * </output>
 *
 * <code title="Preselect">
 * <f:form.radio name="myRadio" value="someValue" checked="{object.value} == 5" />
 * </code>
 * <output>
 * <input type="radio" name="myRadio" value="someValue" checked="checked" />
 * (depending on $object)
 * </output>
 *
 */
class RadioViewHelper extends AbstractFormFieldViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'input';

    /**
     * Initialize the arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerTagAttribute(
            'disabled', 'string', 'Specifies that the input element should be disabled when the page loads'
        );
        // Todo: implement errorClass behavior
//        $this->registerArgument(
//            'errorClass', 'string', 'CSS class to set if there are errors for this view helper', false, 'f3-form-error'
//        );
        $this->overrideArgument('value', 'string', 'Value of input tag. Required for checkboxes', true);
        $this->registerUniversalTagAttributes();
        $this->registerArgument('checked', 'bool', 'Specifies that the input element should be preselected');
    }

    /**
     * Renders the checkbox.
     *
     * @return string
     */
    public function render()
    {
        $this->tag->addAttribute('type', 'radio');

        $this->tag->addAttribute('name', $this->arguments['name']);
        $this->tag->addAttribute('value', $this->arguments['value']);

        if ($this->arguments['checked'] === true) {
            $this->tag->addAttribute('checked', 'checked');
        }

//        $this->setErrorClassAttribute();
        $hiddenField = sprintf('<input type="hidden" name="%s" value="" />', $this->arguments['name']);

        return $hiddenField . $this->tag->render();
    }
}