<?php

use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * UserContext.
 */
class UserContext extends AbstractContext
{
    protected const ENDPOINT = '/users';

    /**
     * @When /^I try to get a list of users$/
     */
    public function iTryToGetAListOfUsers(): void
    {
        $this->restContext->sendRequest(
            Request::METHOD_GET,
            self::ENDPOINT
        );
    }

    /**
     * @Then /^I see a list of users$/
     */
    public function iSeeAListOfUsers(): void
    {
        $this->minkContext->assertResponseStatus(Response::HTTP_OK);
        $this->jsonContext->theJsonNodeShouldHaveElements('hydra:member', 3);
    }
}
