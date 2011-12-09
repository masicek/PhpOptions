<?php

/*
 * PhpOptions
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

// path to tested classes
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..');

// include my TestCase
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Unit' . DIRECTORY_SEPARATOR . 'TestCase.php';


$argvInput = $_SERVER['argv'];

// Unit tests
$argv = $argvInput;
$argv[0] = 'boot.php';
$argv[] = '--strict';
$argv[] = '--coverage-html';
$argv[] = './Coverage';
$argv[] = '.' . DIRECTORY_SEPARATOR . 'Unit';
$_SERVER['argv'] = $argv;
PHPUnit_TextUI_Command::main(FALSE);

// Regression tests
$argv = $argvInput;
$argv[0] = 'boot.php';
$argv[] = '--strict';
$argv[] = '.' . DIRECTORY_SEPARATOR . 'Regression';
$_SERVER['argv'] = $argv;
PHPUnit_TextUI_Command::main();
