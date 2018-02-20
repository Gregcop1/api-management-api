<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;
use Fidry\AliceDataFixtures\LoaderInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    const TAG_READ = 'read';

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var RestContext
     */
    private $restContext;

    /**
     * @var SchemaTool
     */
    private $schemaTool;

    /**
     * @var array
     */
    private $classes;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var LoaderInterface
     */
    private $loader;

    /**
     * @var string
     */
    private $rootDir;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     * @param ManagerRegistry $doctrine
     * @param LoaderInterface $loader
     * @param string $rootDir
     */
    public function __construct(ManagerRegistry $doctrine, LoaderInterface $loader, string $rootDir)
    {
        $this->doctrine = $doctrine;
        $this->manager = $this->doctrine->getManager();
        $this->schemaTool = new SchemaTool($this->manager);
        $this->classes = $this->manager->getMetadataFactory()->getAllMetadata();
        $this->loader = $loader;
        $this->rootDir = $rootDir;
    }

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
    }

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     */
    public function loadAttributes(BeforeScenarioScope $scope): void
    {
        $tags = \array_merge($scope->getFeature()->getTags(), $scope->getScenario()->getTags());
        $this->prepare(in_array(self::TAG_READ, $tags, true));
    }

    /**
     * @param bool $readOnly
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    private function prepare($readOnly = false): void
    {
        if (!$readOnly) {
            $this->resetDatabase();
            $this->loadFixtures();
        }
    }

    /**
     * Purge database.
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    private function resetDatabase(): void
    {
        $this->schemaTool->dropSchema($this->classes);
        $this->schemaTool->createSchema($this->classes);

        $purger = new ORMPurger($this->manager);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
    }

    /**
     * Load fixtures.
     * @throws \InvalidArgumentException
     */
    private function loadFixtures(): void
    {
        $this->loader->load($this->getFixtures());
        $this->doctrine->getManager()->clear();
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    private function getFixtures(): array
    {
        /** @var Finder $finder */
        $finder = (new Finder())
            ->files()
            ->in($this->rootDir.'/Resources/fixtures')
            ->name('*.yml');

        $data = [];
        foreach ($finder as $fileInfo) {
            $data[] = $fileInfo->getRealPath();
        }

        return $data;
    }
}
