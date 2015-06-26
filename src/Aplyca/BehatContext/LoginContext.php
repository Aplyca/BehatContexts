<?php

namespace Aplyca\BehatContext;

/**
 * Login context.
 */
class LoginContext extends BaseContext
{
    private $parameters;
    private $selectors;
    private $credentials;

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
        $this->Credentials = Yaml::parse(file_get_contents('tests/behat/credentials.yml'));
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
     * @Given /^I am logged in as "([^"]*)"$/
     */
    public function iAmLoggedInAs($user)
    {
        $parameters = $this->Parameters;
        $credentials = $this->Credentials;

        $baseURL = $this->getMinkParameter('base_url');
        $loginURL = $baseURL . $parameters["login"]["URL"];
        $redirectAfterLoginURL = $baseURL . $parameters["login"]["redirectURL"];

        $session = $this->getMink()->getSession()->visit( $loginURL );
        $this->assertResponseStatus("200");

        $this->fillField($parameters["login"]["username field"], $credentials[$user]["username"]);
        $this->fillField($parameters["login"]["password field"], $credentials[$user]["password"]);
        $this->pressButton($parameters["login"]["login button"]);

        $this->assertPageAddress($redirectAfterLoginURL);
        $this->assertResponseStatus("200");
    }
}
