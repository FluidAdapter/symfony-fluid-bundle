<?php
namespace FluidAdapter\SymfonyFluidBundle\ViewHelpers\Form;

use FluidAdapter\SymfonyFluidBundle\Error\Form\InvalidOptionsException;

/**
 * This view helper generates a <select> dropdown list for the use with a form.
 *
 * = Basic usage =
 *
 * The most straightforward way is to supply an associative array as the "options" parameter.
 * The array key is used as option key, and the value is used as human-readable name.
 *
 * <code title="Basic usage">
 * <f:form.select name="paymentOptions" options="{payPal: 'PayPal International Services', visa: 'VISA Card'}" />
 * </code>
 *
 * = Pre-select a value =
 *
 * To pre-select a value, set "value" to the option key which should be selected.
 * <code title="Default value">
 * <f:form.select name="paymentOptions" options="{payPal: 'PayPal International Services', visa: 'VISA Card'}" value="visa" />
 * </code>
 * Generates a dropdown box like above, except that "VISA Card" is selected.
 *
 * If the select box is a multi-select box (multiple="1"), then "value" can be an array as well.
 *
 * = Custom options and option group rendering =
 *
 * Child nodes can be used to create a completely custom set of ``<option>`` and ``<optgroup>`` tags in a way compatible with
 * the HMAC generation. To do so, leave out the ``options`` argument and use child ViewHelpers:
 * <code title="Custom options and optgroup">
 * <f:form.select name="myproperty">
 *     <f:form.select.option value="1">Option one</f:form.select.option>
 *     <f:form.select.option value="2">Option two</f:form.select.option>
 *     <f:form.select.optgroup>
 *         <f:form.select.option value="3">Grouped option one</f:form.select.option>
 *         <f:form.select.option value="4">Grouped option twi</f:form.select.option>
 *     </f:form.select.optgroup>
 * </f:form.select>
 * </code>
 * Note: do not use vanilla ``<option>`` or ``<optgroup>`` tags! They will invalidate the HMAC generation!
 *
 * = Usage on domain objects =
 *
 * If you want to output domain objects, you can just pass them as array into the "options" parameter.
 * To define what domain object value should be used as option key, use the "optionValueField" variable. Same goes for optionLabelField.
 * If neither is given, the Identifier (UID/uid) and the __toString() method are tried as fallbacks.
 *
 * If the optionValueField variable is set, the getter named after that value is used to retrieve the option key.
 * If the optionLabelField variable is set, the getter named after that value is used to retrieve the option value.
 *
 * If the prependOptionLabel variable is set, an option item is added in first position, bearing an empty string or -
 * If provided, the value of the prependOptionValue variable as value.
 *
 * <code title="Domain objects">
 * <f:form.select name="users" options="{userArray}" optionValueField="id" optionLabelField="firstName" />
 * </code>
 * In the above example, the userArray is an array of "User" domain objects, with no array key specified.
 *
 * So, in the above example, the method $user->getId() is called to retrieve the key, and $user->getFirstName() to retrieve the displayed value of each entry.
 *
 * The "value" property now expects a domain object, and tests for object equivalence.
 *
 * @api
 */
class SelectViewHelper extends AbstractFormFieldViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'select';

    /**
     * @var mixed
     */
    protected $selectedValue = null;

    /**
     * Initialize arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('size', 'string', 'Size of input field');
        $this->registerTagAttribute('disabled', 'string', 'Specifies that the input element should be disabled when the page loads');
        $this->registerArgument('options', 'array|object', 'Associative array with internal IDs as key, and the values are displayed in the select box. Can be combined with or replaced by child f:form.select.* nodes.');
//        $this->registerArgument('optionValueField', 'string', 'If specified, will call the appropriate getter on each object to determine the value.');
//        $this->registerArgument('optionLabelField', 'string', 'If specified, will call the appropriate getter on each object to determine the label.');
        $this->registerArgument('sortByOptionLabel', 'boolean', 'If true, List will be sorted by label.', false, false);
        $this->registerArgument('selectAllByDefault', 'boolean', 'If specified options are selected if none was set before.', false, false);
//        $this->registerArgument('errorClass', 'string', 'CSS class to set if there are errors for this view helper', false, 'f3-form-error');
        $this->registerArgument('prependOptionLabel', 'string', 'If specified, will provide an option at first position with the specified label.');
        $this->registerArgument('prependOptionValue', 'string', 'If specified, will provide an option at first position with the specified value.');
        $this->registerArgument('multiple', 'boolean', 'If set multiple options may be selected.', false, false);
    }

    /**
     * Render the tag.
     *
     * @return string rendered tag.
     * @api
     */
    public function render()
    {
        if ($this->arguments['multiple']) {
            $this->tag->addAttribute('multiple', 'multiple');
            $this->arguments['name'] .= '[]';
        }
        $this->tag->addAttribute('name', $this->arguments['name']);

        $options = $this->getOptions();

//        $this->setErrorClassAttribute();
        $content = '';
        $content .= $this->renderHiddenFieldForEmptyValue() . PHP_EOL;

        $tagContent = PHP_EOL . $this->renderOptionTags($options);
        $tagContent .= $this->renderChildren();

        $this->tag->setContent($tagContent);
        $content .= $this->tag->render();

        return $content;
    }

    /**
     * Render the option tags.
     *
     * @param array $options the options for the form.
     * @return string rendered tags.
     */
    protected function renderOptionTags($options)
    {
        $output = '';
        if ($this->hasArgument('prependOptionLabel')) {
            $value = $this->hasArgument('prependOptionValue') ? $this->arguments['prependOptionValue'] : '';
            $label = $this->arguments['prependOptionLabel'];
            $output .= $this->renderOptionTag($value, $label, false) . PHP_EOL;
        }
        foreach ($options as $value => $label) {
            $isSelected = $this->isSelected($value);
            $output .= $this->renderOptionTag($value, $label, $isSelected) . PHP_EOL;
        }
        return $output;
    }

    /**
     * Render the option tags.
     * @return array an associative array of options, key will be the value of the option tag
     * @throws InvalidOptionsException
     * @throws \Exception
     */
    protected function getOptions()
    {
        if (!is_array($this->arguments['options']) && !$this->arguments['options'] instanceof \Traversable) {
            throw new InvalidOptionsException('options must be an array or a traversable object.');
        }
        $options = [];
        $optionsArgument = $this->arguments['options'];
        foreach ($optionsArgument as $key => $value) {
            if (is_object($value) || is_array($value)) {
                if (method_exists($value, '__toString')) {
                    $key = (string)$value;
                } else {
                    throw new InvalidOptionsException('No identifying value for object of class "' . get_class($value) . '" found.');
                }
                if (method_exists($value, '__toString')) {
                    $value = (string)$value;
                }
            }
            $options[$key] = $value;
        }
        if ($this->arguments['sortByOptionLabel']) {
            asort($options, SORT_LOCALE_STRING);
        }
        return $options;
    }
    /**
     * Render the option tags.
     *
     * @param mixed $value Value to check for
     * @return bool TRUE if the value should be marked a s selected; FALSE otherwise
     */
    protected function isSelected($value)
    {
        $selectedValue = $this->arguments['value'];
        if ($value === $selectedValue || (string)$value === $selectedValue) {
            return true;
        }
        if ($this->hasArgument('multiple')) {
            if (is_null($selectedValue) && $this->arguments['selectAllByDefault'] === true) {
                return true;
            } elseif (is_array($selectedValue) && in_array($value, $selectedValue)) {
                return true;
            }
        }
        return false;
    }
    /**
     * Retrieves the selected value(s)
     *
     * @return mixed value string or an array of strings
     */
    protected function getSelectedValue()
    {
        if (!is_array($this->arguments['value']) && !$this->arguments['value'] instanceof \Traversable) {
            return $this->getOptionValueScalar($this->arguments['value']);
        }
        $selectedValues = [];
        foreach ($this->arguments['value'] as $selectedValueElement) {
            $selectedValues[] = $this->getOptionValueScalar($selectedValueElement);
        }
        return $selectedValues;
    }
    /**
     * Get the option value for an object
     *
     * @param mixed $valueElement
     * @return string
     */
    protected function getOptionValueScalar($valueElement)
    {
        if (is_object($valueElement)) {
            if ($this->hasArgument('optionValueField')) {
//                return \TYPO3\CMS\Extbase\Reflection\ObjectAccess::getPropertyPath($valueElement, $this->arguments['optionValueField']);
            }
        }

        return $valueElement;
    }
    /**
     * Render one option tag
     *
     * @param string $value value attribute of the option tag (will be escaped)
     * @param string $label content of the option tag (will be escaped)
     * @param bool $isSelected specifies wheter or not to add selected attribute
     * @return string the rendered option tag
     */
    protected function renderOptionTag($value, $label, $isSelected)
    {
        $output = "\t" . '<option value="' . htmlspecialchars($value) . '"';
        if ($isSelected) {
            $output .= ' selected="selected"';
        }
        $output .= '>' . htmlspecialchars($label) . '</option>';
        return $output;
    }
}
