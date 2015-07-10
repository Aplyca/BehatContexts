Feature: Form fill inputs a web page
      In order to validate the existence of selectors in form
      As an anonymous
      I need to be able to see the seelctors of the page

Background:
    Given I am on homepage

Scenario: Fill and validate form options
    Given I select "Option 1" from "Select options"
    Then the "Option 1" option from "Select options" should be selected
        And the option "Option 1" from "Select options" is selected
        And "Option 1" from "Select options" is selected

