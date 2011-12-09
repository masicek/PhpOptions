<?php

/*
 * PhpOptions
 *
 * Run all scripts (Minifing, Tests(unit, regression, minifing), Docs)
 *
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */


// create tmp mini version
copy(__DIR__ . '/Minifing/PhpOptions.min.php', __DIR__ . '/Minifing/PhpOptions.min.tmp.php');

require_once __DIR__ . '/Minifing/PhpOptions.min.tmp.php';

use PhpOptions\Options;
use PhpOptions\Option;

// set options + help
$optionsList = array();
$optionsList[] = Option::make('Help')->description('Show this help');
$optionsList[] = Option::make('All')->description('Run script parts (Minifing, Tests(unit, regression, minifing), Docs)');
$optionsList[] = Option::make('Minifing')->description('Run script for making minified veriosn of PhpOptions');
$optionsList[] = Option::make('Tests')->description('Run all tests');
$optionsList[] = Option::make('Tests unit')->short()->long('tu')->description('Run unit tests');
$optionsList[] = Option::make('Tests regression')->short()->long('tr')->description('Run regression tests');
$optionsList[] = Option::make('Tests minifing')->short()->long('tm')->description('Run minifing tests');
$optionsList[] = Option::make('Docs')->description('Run script for generating API documenation of PhpOptions');

$options = new Options();
$options->add($optionsList);
$options->defaults('Help');
$version = Options::VERSION;
$options->description(
	"PhpOptions $version\nauthor: Viktor Masicek <viktor@masicek.net>\n\n" .
	"Script for generating minified version, running tests\n" .
	"and generating API documentation of PhpOptions."
);

// Help
if ($options->get('Help'))
{
	fwrite(STDOUT, $options->getHelp());
	return;
}

$all = $options->get('All');

// Minifing
if ($all || $options->get('Minifing'))
{
	fwrite(STDOUT, "Generate Minifing:\n------------------\n");
	$output = array();
	exec('php ' . __DIR__ . '/Minifing/run.php', $output);
	fwrite(STDOUT, implode("\n", $output) . "\n");
}

// Tests
$testsOptions = '';
if ($all || $options->get('Tests'))
{
	$testsOptions .= '-r -m -u';
}
else
{
	if ($options->get('Tests regression'))
	{
		$testsOptions .= '-r';
	}

	if ($options->get('Tests minifing'))
	{
		$testsOptions .= '-m';
	}

	if ($options->get('Tests unit'))
	{
		$testsOptions .= '-u';
	}
}

if ($testsOptions)
{
	fwrite(STDOUT, "Run Tests:\n----------\n");
	$output = array();
	exec('php ' . __DIR__ . '/Tests/run.php ' . $testsOptions, $output);
	fwrite(STDOUT, implode("\n", $output) . "\n");
}

// Docs
if ($all || $options->get('Docs'))
{
	// TODO verbous
	fwrite(STDOUT, "Generate Documentation:\n-----------------------\n");
	$output = array();
	exec('php ' . __DIR__ . '/Docs/run.php', $output);
	fwrite(STDOUT, implode("\n", $output) . "\n");
	fwrite(STDOUT, "documentation generated\n");
}

// delete tmp mini version
unlink(__DIR__ . '/Minifing/PhpOptions.min.tmp.php');
