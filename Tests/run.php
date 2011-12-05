<?php

/*
 * PhpOption
 *
 * Run all PHPUnit tests
 *
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */


// set libs as include path
$libs = __DIR__ . DIRECTORY_SEPARATOR . 'Libs' . DIRECTORY_SEPARATOR . 'PHPUnit';
set_include_path(get_include_path() . PATH_SEPARATOR . $libs);
require_once 'PHPUnit/Autoload.php';

// include my TestCase
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Unit' . DIRECTORY_SEPARATOR . 'TestCase.php';

// path to tested classes
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..');

// simulate command line runnig (set arguments)
$argv = $_SERVER['argv'];
$arg[0] = 'boot.php';
// set strict mode
$arg[] = '--strict';
// generate code coverage
$argv[] = '--coverage-html';
$argv[] = './Coverage';
// tests
$argv[] = '.' . DIRECTORY_SEPARATOR . 'Unit';
$_SERVER['argv'] = $argv;

// run tests
PHPUnit_TextUI_Command::main();
