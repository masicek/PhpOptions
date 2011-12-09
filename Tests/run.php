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

// detect which trsts run
$runUnit = FALSE;
$runRegression = FALSE;
$runMinifing = FALSE;

$opts = getopt('urm');
if (isset($opts['u']))
{
	$runUnit = TRUE;
	unset($_SERVER['argv'][array_search('-u', $_SERVER['argv'])]);
}
if (isset($opts['r']))
{
	$runRegression = TRUE;
	unset($_SERVER['argv'][array_search('-r', $_SERVER['argv'])]);
}
if (isset($opts['m']))
{
	$runMinifing = TRUE;
	unset($_SERVER['argv'][array_search('-m', $_SERVER['argv'])]);
}
if (!$runUnit && !$runRegression && !$runMinifing)
{
	$runUnit = TRUE;
	$runRegression = TRUE;
	$runMinifing = TRUE;
}


// set libs as include path
$libs = __DIR__ . DIRECTORY_SEPARATOR . 'Libs' . DIRECTORY_SEPARATOR . 'PHPUnit';
set_include_path(get_include_path() . PATH_SEPARATOR . $libs);
require_once 'PHPUnit' . DIRECTORY_SEPARATOR . 'Autoload.php';

// path to tested classes
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'PhpOptions');

// include my TestCase
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Unit' . DIRECTORY_SEPARATOR . 'TestCase.php';


$argvInput = $_SERVER['argv'];

// Unit tests
if ($runUnit)
{
	fwrite(STDOUT, "Unit tests:\n-----------\n");
	$argv = $argvInput;
	$argv[0] = 'boot.php';
	$argv[] = '--strict';
	$argv[] = '--coverage-html';
	$argv[] = __DIR__ . DIRECTORY_SEPARATOR . 'Coverage';
	$argv[] = __DIR__ . DIRECTORY_SEPARATOR . 'Unit';
	$_SERVER['argv'] = $argv;
	PHPUnit_TextUI_Command::main(FALSE);
	fwrite(STDOUT, "\n");
}

// Regression tests
if ($runRegression)
{
	fwrite(STDOUT, "Regression tests:\n-----------------\n");
	$argv = $argvInput;
	$argv[0] = 'boot.php';
	$argv[] = '--strict';
	$argv[] = __DIR__ . DIRECTORY_SEPARATOR . 'Regression';
	$_SERVER['argv'] = $argv;
	PHPUnit_TextUI_Command::main(FALSE);
	fwrite(STDOUT, "\n");
}

// Minifing tests
if ($runMinifing)
{
	fwrite(STDOUT, "Minifing tests:\n---------------\n");
	$runMinOutput = array();
	exec('php ' . __DIR__ . DIRECTORY_SEPARATOR . 'runMin.php', $runMinOutput);
	fwrite(STDOUT, implode("\n", $runMinOutput));
}
