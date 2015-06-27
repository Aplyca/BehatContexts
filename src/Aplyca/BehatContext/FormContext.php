<?php

namespace Aplyca\BehatContext;

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
            throw new \InvalidArgumentException("Label '$labelText' not found.");
        }

        // Now use the ID to retrieve the button and click it
        /** @var NodeElement $radioButton */
        $radioButton = $this->getSession()->getPage()->find('css', "#$radioId");
        if (!$radioButton)
        {
            throw new \Exception("$labelText radio button not found.");
        }

        $this->fillField($radioId, $radioButton->getAttribute('value'));
    }
    /**
     * Fill field in form
     * @param  string $field name or label of the field
     * @param  string $value value of the field
     */
    public function fillField($field, $value)
    {
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }    
}
