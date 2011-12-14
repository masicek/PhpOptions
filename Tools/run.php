<?php

/*
 * PhpOptions
 *
 * Run Runner of scripts
 *
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Runner.php';
$runner = new PhpOptions\Tools\Runner();
$runner->run();
