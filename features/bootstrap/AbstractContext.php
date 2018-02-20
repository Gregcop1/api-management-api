<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\MinkContext;
use Behatch\Context\JsonContext;

/**
 * AbstractContext.
 */
abstract class AbstractContext implements Context
{
    protected const ENDPOINT = '';

    /**
     * @var RestContext
     */
    protected $restContext;

    /**
     * @var JsonContext
     */
    protected $jsonContext;

    /**
     * @var MinkContext
     */
    protected $minkContext;

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
        $this->jsonContext = $environment->getContext(JsonContext::class);
        $this->minkContext = $environment->getContext(MinkContext::class);
    }
}
