<?php

namespace Aplyca\BehatContext;

use Behat\Behat\Context\Context as ContextInterface,
    Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Behat\Hook\Scope\BeforeScenarioScope,
    Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode,
    Behat\MinkExtension\Context\MinkContext,
    Symfony\Component\Yaml\Yaml,
    Symfony\Component\Yaml\Exception\ParseException,
    Behat\Behat\Context\TranslatableContext,
    Behat\MinkExtension\Context\RawMinkContext,
    Behat\Mink\Exception\ExpectationException;

/**
 * Base context.
 */
class BaseContext extends RawMinkContext {
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
     * Returns fixed step argument (with \\" replaced back to ").
     *
     * @param string $argument
     *
     * @return string
     */
    protected function fixStepArgument($argument)
    {
        return str_replace('\\"', '"', $argument);
    }
}
