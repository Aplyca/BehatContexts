<?php

namespace Aplyca\BehatContext;

use Behat\Mink\Element\Element,
    Behat\Mink\Exception\ElementNotFoundException;

/**
 * Form context.
 */
class FormContext extends BaseContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param   array   $parameters     context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters = array())
    {
        $this->Parameters = $parameters;
    }

    /**
     * @Given /^I select the "([^"]*)" option from "([^"]*)"$/
     */
    public function iSelectTheOptionFrom($labelText, $arg2)
    {
        // Find the label by its text, then use that to get the radio item's ID
        $radioId = null;

        /** @var $label NodeElement */
        foreach ($this->getSession()->getPage()->findAll('css', 'label') as $label) {
            if ($labelText === $label->getText()) {
                if ($label->hasAttribute('for')) {
                    $radioId = $label->getAttribute('for');
                    break;
                } else {
                    throw new \Exception("Radio button's label needs the 'for' attribute to be set");
                }
            }
        }
        if (!$radioId) {
            throw new ElementNotFoundException($this->getSession(), 'radio field', 'label', $labelText);
        }

        // Now use the ID to retrieve the button and click it
        /** @var NodeElement $radioButton */
        $radioButton = $this->getSession()->getPage()->find('css', "#$radioId");
        if (!$radioButton) {
            throw new ElementNotFoundException($this->getSession(), 'radio field', 'label', $labelText);
        }

        $this->fillField($radioId, $radioButton->getAttribute('value'));
    }

    /**
     * Checks, that option from select with specified id|name|label|value is selected.
     *
     * @Then /^the "(?P<option>(?:[^"]|\\")*)" option from "(?P<select>(?:[^"]|\\")*)" (?:is|should be) selected/
     * @Then /^the option "(?P<option>(?:[^"]|\\")*)" from "(?P<select>(?:[^"]|\\")*)" (?:is|should be) selected$/
     * @Then /^"(?P<option>(?:[^"]|\\")*)" from "(?P<select>(?:[^"]|\\")*)" (?:is|should be) selected$/
     */
    public function theOptionFromShouldBeSelected($option, $select)
    {
        $selectField = $this->getSession()->getPage()->findField($select);
        if (null === $selectField) {
            throw new ElementNotFoundException($this->getSession(), 'select field', 'id|name|label|value', $select);
        }

        $optionField = $selectField->find('named', array(
            'option',
            $option,
        ));

        if (null === $optionField) {
            throw new ElementNotFoundException($this->getSession(), 'select option field', 'id|name|label|value', $option);
        }

        $this->assertBoolean($optionField->isSelected(), 'Select option field with value|text "'.$option.'" is not selected in the select "'.$select.'"');
    }
}
