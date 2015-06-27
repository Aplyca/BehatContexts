<?php

namespace Aplyca\BehatContext;

use Behat\Behat\Hook\Scope\BeforeScenarioScope,
    Symfony\Component\Yaml\Yaml;

/**
 * Selectors context.
 */
class SelectorsContext extends BaseContext
{
    private $selectors;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param   array   $selectors     context selectors (set them up through behat.yml)
     */
    public function __construct($selectors = array())
    {
        $this->Selectors = $selectors;
    }

    /** @BeforeScenario */
    public function loadSelectors(BeforeScenarioScope $scope)
    {
        if (is_string($this->Selectors)) {
            $this->Selectors = Yaml::parse(file_get_contents($this->Selectors));
        }
    }

    public function getSelector($item, $feature)
    {
        $selectors = $this->Selectors;

        if (isset($selectors[$feature][$item]))
        {
            return $selectors[$feature][$item];
        } else {
            throw new \Exception(
                'The "'.$item.'" in "'.$feature.'" selector is not defined.'
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
            $this->assertSession()->elementsCount('css', $selector, intval($amount));
        } else {
            $this->assertSession()->elementExists('css', $selector);
        }
    }

    /**
     * @Then /^I should not see ([0-9]*)\s*"([^"]*)" in the "([^"]*)"$/
     */
    public function iShouldNotSeeInThe($amount = 0, $item = "", $feature = "")
    {
        $selector = $this->getSelector($item, $feature);
        if ($amount > 0) {
            $this->assertSession()->elementsCount('css', $selector, intval($amount));
        } else {
            $this->assertSession()->elementNotExists('css', $selector);
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

        $this->assertSession()->elementTextContains('css', $selector, $this->fixStepArgument($text));
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

        $this->assertSession()->elementTextNotContains('css', $selector, $this->fixStepArgument($text));
    }
}
