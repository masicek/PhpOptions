<?php

/**
 * You can print help by option '-h' or '--help'.
 * Also, you can print help when run script without any options.
 *
 * Possible using:
 * php groups.php
 */

require_once __DIR__ . '/../Options.php';
require_once __DIR__ . '/../Option.php';

use PhpOptions\Options;
use PhpOptions\Option;


// define options
try {

	$optionsList = array();
	$optionsList[] = Option::make('Help');
	$optionsList[] = Option::make('A First')->short();
	$optionsList[] = Option::make('A Second')->short();
	$optionsList[] = Option::make('B First')->short();
	$optionsList[] = Option::make('B Second')->short();
	$optionsList[] = Option::make('B Third')->short();
	$optionsList[] = Option::make('C First')->short();

	$options = new Options();
	$options->add($optionsList);
	$options->group('Group A', array('A First', 'A Second'));
	$options->group('Group B', array('B First', 'B Second', 'B Third'));
	$options->group('Group C', 'C First');
	$options->def('Help');
	$options->description("Simple script demonstrating using groups of options of PhpOptions\nauthor: Viktor Masicek <viktor@masicek.net>");
} catch (Exception $e) {
	echo $e->getMessage();
	die();
}


// using options
if ($options->get('Help'))
{
	echo $options->getHelp();
	return;
}
