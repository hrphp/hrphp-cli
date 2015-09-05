<?php
/**
 * This file is part of the hrphp-cli package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Console\Application;
use Hrphp\Cli\Command\PingCommand;
use GuzzleHttp\Client as GuzzleClient;

try {
    $client = new GuzzleClient();
    $application = new Application('HRPHP CLI', '@package_version@');
    $application->add(new PingCommand($client));
} catch (\Exception $ex) {
    printf('An error occurred: %s%s', $ex->getMessage(), PHP_EOL);
    exit(1);
}
