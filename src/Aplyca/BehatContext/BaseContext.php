<?php

namespace Aplyca\BehatContext;

use Behat\Behat\Context\Context,
    Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Behat\Hook\Scope\BeforeScenarioScope,
    Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode,
    Behat\MinkExtension\Context\MinkContext,
    Symfony\Component\Yaml\Yaml,
    Symfony\Component\Yaml\Exception\ParseException;

/**
 * Base context.
 */
class BaseContext extends MinkContext
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
}
