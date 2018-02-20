<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AuthContext.
 */
class AuthContext implements Context
{
    /**
     * @var RestContext
     */
    private $restContext;

    /**
     * @var MinkContext
     */
    private $minkContext;

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     * @throws \Behat\Behat\Context\Exception\ContextNotFoundException
     */
    public function gatherContext(BeforeScenarioScope $scope): void
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();
        $this->restContext = $environment->getContext(RestContext::class);
        $this->minkContext = $environment->getContext(MinkContext::class);
    }

    /**
     * @Given /^I am authenticated as (admin|user)$/
     * @param string $role
     */
    public function iAmAuthenticatedAs(string $role): void
    {
        $this->restContext->iAddHeaderEqualTo(
            'Authorization',
            \sprintf('Bearer %s', $this->getToken('admin' === $role))
        );
    }

    /**
     * @Given I am not authenticated
     */
    public function iAmNotAuthenticated(): void
    {
        $this->restContext->iAddHeaderEqualTo('Authorization', 'null');
    }

    /**
     * @param bool $admin
     * @return string
     * @throws \RuntimeException
     */
    private function getToken(bool $admin = false): string
    {
        $data = ['username' => $admin ? 'olivier' : 'gregory', 'password' => 'password'];

        $this
            ->restContext
            ->sendRequest(Request::METHOD_POST, '/login_check', $data)
        ;

        $response = $this->restContext->getContent();
        if (!isset($response->token)) {
            throw new \RuntimeException(\sprintf(
                'No token at login_check, got %s as response',
                $response->message)
            );
        }

        return $response->token;
    }

    /**
     * @Then /^I should be unauthorized$/
     */
    public function iShouldBeUnauthorized()
    {
        $this->minkContext->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }

}
