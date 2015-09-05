<?php
/**
 * This file is part of the hrphp-cli package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HrphpTest\Cli\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Hrphp\Cli\Command\PingCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;

class PingCommandTest extends \PHPUnit_Framework_TestCase
{
    /** @var Application */
    private $application;

    /**
     * @var Client
     */
    private $client;

    public function testPing()
    {
        $commandTester = $this->getCommandTester('ping');
        $output = $commandTester->getDisplay();
        self::assertContains(sprintf('command', HRPHP_URL), $output);
        self::assertContains(sprintf('%s is up!', HRPHP_URL), $output);
    }

    public function testVerbosePing()
    {
        $commandTester = $this->getCommandTester(
            'ping',
            [ 'verbosity' => OutputInterface::VERBOSITY_VERBOSE ]
        );
        $output = $commandTester->getDisplay();
        self::assertContains('Attempting to hit', $output);
    }

    public function testVeryVerbosePing()
    {
        $commandTester = $this->getCommandTester(
            'ping',
            [ 'verbosity' => OutputInterface::VERBOSITY_VERY_VERBOSE ]
        );
        $output = $commandTester->getDisplay();
        self::assertContains('Ping being sent from', $output);
    }

    protected function setUp()
    {
        $command = new PingCommand($this->getClient());
        $this->application = new Application();
        $this->application->add($command);
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        if (!$this->client) {
            $mock = new MockHandler([
                new Response(200, [ 'X-Foo' => 'Bar' ]),
            ]);
            $handler = HandlerStack::create($mock);
            $this->client = new Client([ 'handler' => $handler ]);
        }
        return $this->client;
    }

    /**
     * @param string $commandName
     * @param array $options
     * @return CommandTester
     */
    protected function getCommandTester($commandName, array $options = [])
    {
        $command = $this->getApplication()->find($commandName);
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $commandName], $options);
        return $commandTester;
    }

    /**
     * @return Application
     */
    protected function getApplication()
    {
        return $this->application;
    }
}
