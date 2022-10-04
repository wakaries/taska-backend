<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Process\Process;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DemoContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given a fixtured database with group :group
     */
    public function aFixturedDatabaseWithGroup($group)
    {
        $commands = [
            'php bin/console --env=test doctrine:database:drop --force',
            'php bin/console --env=test doctrine:database:create',
            'php bin/console --env=test doctrine:migrations:migrate -n',
            'php bin/console --env=test doctrine:fixtures:load -n --group=' . $group
        ];
        foreach ($commands as $command) {
            $process = Process::fromShellCommandline($command);
            $process->run();    
        }
    }
    
    /**
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path): void
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
    }
}
