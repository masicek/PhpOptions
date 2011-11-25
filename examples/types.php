<?php

/**
 * This script print all set options. Options have set types for check values.
 * You can print help by option '-h' or '--help'.
 * Also, you can print help when run script without any options.
 *
 * Possible using:
 * php types.php
 * php types.php -s "Lorem ipsum" -c "x" -i "-1234" --iu 999 -r "-888.222" --ru 777.05 -d "2001-02-5" --dt "2011-dec-12 2:00PM" -t 3PM --dir "../Types/" -f "../Types/IType.php" -e viktor@masicek.net --enum bbb
 *
 * Exception terminated:
 * php types.php -c "xy"
 * php types.php -i x2bv5
 * php types.php --iu "-123"
 * php types.php -r a123.9
 * php types.php --ru "-777.05"
 * php types.php -d "2001-100-5"
 * php types.php --dt "2011-ss-12 2:00PM"
 * php types.php -t Lorem
 * php types.php --dir "../TypesX/"
 * php types.php -f "../Types/IType"
 * php types.php -e viktormasicek.net
 * php types.php --enum qqq
 */

require_once __DIR__ . '/../Options.php';
require_once __DIR__ . '/../Option.php';

use PhpOptions\Options;
use PhpOptions\Option;


// define options
try {

	$optionsList = array();
	$optionsList[] = Option::make('Help');
	$optionsList[] = Option::string('String');
	$optionsList[] = Option::char('Char');
	$optionsList[] = Option::integer('Integer');
	$optionsList[] = Option::integer('Integer unsigned', 'unsigned')->short()->long('iu');
	$optionsList[] = Option::real('Real');
	$optionsList[] = Option::real('Real unsigned', 'unsigned')->short()->long('ru');
	$optionsList[] = Option::date('Date');
	$optionsList[] = Option::datetime('Datetime')->short()->long('dt');
	$optionsList[] = Option::time('Time');
	$optionsList[] = Option::directory('Directory')->short()->long('dir');
	$optionsList[] = Option::file('File');
	$optionsList[] = Option::email('Email');
	$optionsList[] = Option::enum('Enum', array('a', 'bbb', 1234))->short();

	$options = new Options();
	$options->add($optionsList);
	$options->def('Help');
	$options->description("Simple script demonstrating using types of values of PhpOptions\nauthor: Viktor Masicek <viktor@masicek.net>");
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

echo 'String: ' . $options->get('String') . "\n";
echo 'Char: ' . $options->get('Char') . "\n";
echo 'Integer: ' . $options->get('Integer') . "\n";
echo 'Integere unsigned: ' . $options->get('Integer unsigned') . "\n";
echo 'Real: ' . $options->get('Real') . "\n";
echo 'Real unsigned: ' . $options->get('Real unsigned') . "\n";
echo 'Date: ' . $options->get('Date') . "\n";
echo 'Datetime: ' . $options->get('Datetime') . "\n";
echo 'Time: ' . $options->get('Time') . "\n";
echo 'Directory: ' . $options->get('Directory') . "\n";
echo 'File: ' . $options->get('File') . "\n";
echo 'Email: ' . $options->get('Email') . "\n";
echo 'Enum: ' . $options->get('Enum') . "\n";
