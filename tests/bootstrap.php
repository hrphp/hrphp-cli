<?php
/**
 * This file is part of the hrphp-cli package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

date_default_timezone_set('America/New_York');

define('APPLICATION_ENV', 'test');

define('APPLICATION_PATH', dirname(__DIR__));
chdir(APPLICATION_PATH);

require 'vendor/autoload.php';
require 'src/config/application.php';
