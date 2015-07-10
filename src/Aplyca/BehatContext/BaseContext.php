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

    /**
     * Checks, that current page response status is equal to specified.
     *
     * @param  int $code HTTP status code
     * @throws Behat\Mink\Exception\ExpectationException when current response status is not equal to $code
     */
    public function assertResponseStatus($code)
    {
        $this->assertSession()->statusCodeEquals($code);
    }

    /**
     * Fill field in form
     *
     * @param  string $field name or label of the field
     * @param  string $value value of the field
     */
    public function fillField($field, $value)
    {
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }
    /**
     * Checks, that current page PATH is equal to specified.
     *
     * @param  string $page URL of the page
     * @throws Behat\Mink\Exception\ExpectationException when the current page does not match $page
     */
    public function assertPageAddress($page)
    {
        $this->assertSession()->addressEquals($this->locatePath($page));
    }

    /**
     * Asserts a condition.
     *
     * @param bool   $condition
     * @param string $message   Failure message
     *
     * @throws ExpectationException when the condition is not fulfilled
     */
    public function assertBoolean($condition, $message)
    {
        if ($condition) {
            return;
        }
        throw new ExpectationException($message, $this->getSession());
    }

}
