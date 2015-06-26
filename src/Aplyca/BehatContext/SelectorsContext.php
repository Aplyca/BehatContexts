<?php

namespace Aplyca\BehatContext;

/**
 * Selectors context.
 */
class SelectorsContext extends BaseContext
{
    private $parameters;
    private $selectors;

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

    /** @BeforeScenario */
    public function loadSelectors(BeforeScenarioScope $scope)
    {
        $this->Selectors = Yaml::parse(file_get_contents('tests/behat/selectors.yml'));
    }

    public function getSelector($item, $feature)
    {
        $selectors = $this->Selectors;

        if (isset($selectors[$feature][$item]))
        {
            return $selectors[$feature][$item];
        } else {
            throw new \Exception(
                'The "'.$item.'" in "'.$feature.'" test is not defined.'
            );
        }
    }

    /**
     * @Then /^I should see ([0-9]*)\s*"([^"]*)" in the "([^"]*)"$/
     */
    public function iShouldSeeInThe($amount = 0, $item = "", $feature = "")
    {
        $selector = $this->getSelector($item, $feature);
        if ($amount > 0) {
            $this->assertNumElements($amount, $selector);
        } else {
            $this->assertElementOnPage($selector);
        }
    }

    /**
     * @Then /^I should not see ([0-9]*)\s*"([^"]*)" in the "([^"]*)"$/
     */
    public function iShouldNotSeeInThe($amount = 0, $item = "", $feature = "")
    {
        $selector = $this->getSelector($item, $feature);
        if ($amount > 0) {
            $this->assertNotNumElements($amount, $selector);
        } else {
            $this->assertElementNotOnPage($selector);
        }
    }

    /**
     * @Then /^I should see the text "([^"]*)" in the ([0-9]*)\s*"([^"]*)" of the "([^"]*)"$/
     */
    public function iShouldSeeTheTextInTheOfThe($text = "", $position = 1, $item = "", $feature = "")
    {
        $selector = $this->getSelector($item, $feature);
        if (!empty($position)) {
            $selector = $selector.":nth-child(".$position.")";
        }

        $this->assertElementContainsText($selector, $text);
    }

    /**
     * @Then /^I should not see the text "([^"]*)" in the ([0-9]*)\s*"([^"]*)" of the "([^"]*)"$/
     */
    public function iShouldNotSeeTheTextInTheOfThe($text = "", $position = 1, $item = "", $feature = "")
    {
        $selector = $this->getSelector($item, $feature);
        if (!empty($position)) {
            $selector = $selector.":nth-child(".$position.")";
        }

        $this->assertElementNotContainsText($selector, $text);
    }
}
