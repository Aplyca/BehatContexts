Feature: Selectors sin a web page
      In order to validate the existence of selectors in a web page
      As an anonymous
      I need to be able to see the seelctors of the page

Background:
    Given I am on homepage

Scenario: See selectors of a page
    Then I should see "element(s)" in the "page body"

Scenario: See selectors of a page
    Then I should see "elements" in the "page body"
