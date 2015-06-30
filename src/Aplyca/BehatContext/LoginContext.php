<?php

namespace Aplyca\BehatContext;

use Behat\Behat\Context\Step;

/**
 * Login context.
 */
class LoginContext extends BaseContext
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
     * @Given /^I am logged in as "([^"]*)"$/
     */
    public function iAmLoggedInAs($user)
    {
        $credentials = $this->Parameters["credentials"];
        $loginInfo = $this->Parameters["login"];
        $baseURL = $this->getMinkParameter('base_url');

        $session = $this->getMink()->getSession()->visit( $baseURL . $loginInfo["url"] );
        $this->assertResponseStatus("200");

        $this->fillField($loginInfo["username_field"], $credentials[$user]["username"]);
        $this->fillField($loginInfo["password_field"], $credentials[$user]["password"]);
        $this->pressButton($loginInfo["login_button"]);

        $this->assertPageAddress($baseURL . $loginInfo["redirect_url"]);
        $this->assertResponseStatus("200");
    }

    /**
     * Presses button with specified id|name|title|alt|value.
     * @param  sttring $button Login form button
     * @throws Behat\Mink\Exception\ElementNotFoundException when no button found
     */
    public function pressButton($button)
    {
        $button = $this->fixStepArgument($button);
        $this->getSession()->getPage()->pressButton($button);
    }
}
