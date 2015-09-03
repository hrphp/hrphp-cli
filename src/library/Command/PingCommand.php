<?php
/**
 * This file is part of the hrphp-cli package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hrphp\Cli\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PingCommand extends Command
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        parent::__construct('ping');
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    protected function configure()
    {
        $this->setName('ping')
            ->setDescription('Pings the HRPHP website');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->getClient()->get(HRPHP_URL);
        /*
        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $output->writeln(sprintf('Attempting to hit %s at %s...', HRPHP_URL, date('H:i:s A')));
        }
        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE) {
            $output->writeln(sprintf('Ping being sent from %s...', gethostname()));
        }
        */
        if ($response->getStatusCode() === 200) {
            $output->writeln(sprintf('%s is up!', HRPHP_URL));
        }
    }
}
