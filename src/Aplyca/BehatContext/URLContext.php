<?php

namespace Aplyca\BehatContext;

/**
 * URL context.
 */
class URLContext extends BaseContext
{
    private $parameters;

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
     * @Then /^the URL scheme should be "([^"]*)"$/
     */
    public function theURLSchemeShouldBe($schema = "http")
    {
        if(empty($schema))
        {
            throw new \InvalidArgumentException("No schema provided");
        }

        $currentURL = $this->getSession()->getCurrentUrl();
        $currentSchema = parse_url($currentURL)["scheme"];
        \PHPUnit_Framework_TestCase::assertEquals($schema, $currentSchema);
    }

    /**
     * @Then /^the URL domain should be "([^"]*)"$/
     */
    public function theURLDomainShouldBe($domain = "")
    {
        if(empty($domain))
        {
            throw new \InvalidArgumentException("No domain provided");
        }

        $currentURL = $this->getSession()->getCurrentUrl();
        $currentDomain = urldecode(parse_url($currentURL)["host"]);
        \PHPUnit_Framework_TestCase::assertEquals($domain, $currentDomain);
    }

    /**
     * @Then /^the URL query should be "([^"]*)"$/
     */
    public function theURLQueryShouldBe($query = "")
    {
        if(empty($query))
        {
            throw new \InvalidArgumentException("No query provided");
        }

        $currentURL = $this->getSession()->getCurrentUrl();
        $currentSchema = urldecode(parse_url($currentURL)["query"]);
        \PHPUnit_Framework_TestCase::assertEquals($query, $currentSchema);
    }
}
