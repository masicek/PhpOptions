<?php

/**
 * This script print your name, if you set them by option '-n' or '--name'.
 * "Name" option have required value.
 * This script print your home directory, if you set them by option '--home-dir'.
 * If you use "home directory" option without value, default value is used.
 * You can print help by option '-h' or '--help'.
 * Also, you can print help when run script without any options.
 *
 * Possible using:
 * php simple.php
 * php simple.php -h
 * php simple.php --help
 * php simple.php -n "Jan Novak"
 * php simple.php --name="Jan Novak"
 * php simple.php --name ="Jan Novak"
 * php simple.php --name "Jan Novak"
 * php simple.php --home-dir
 * php simple.php --home-dir="./home/novakj"
 * php simple.php --name "Jan Novak" --home-dir="./home/novakj"
 * php simple.php --name "Jan Novak" -f "blue" -c "green"
 *
 * Exception terminated:
 * php simple.php -n
 */

require_once __DIR__ . '/../Options.php';
require_once __DIR__ . '/../Option.php';

use PhpOptions\Options;
use PhpOptions\Option;


// define options
try {

	$optionsList = array();
	$optionsList[] = Option::make('Help')->description('Show this help');
	$optionsList[] = Option::make('Name')->description('Name of user')->value();
	$optionsList[] = Option::make('Home')->short()->long('home-dir')->value(FALSE)->def('./home/common')
		->description('Home directory of user');
	$optionsList[] = Option::make('Favorite color')->description('User`s favorite color')->value();
	$optionsList[] = Option::make('Color of eye')->description('User`s color of eye')->value();

	$options = new Options();
	$options->add($optionsList);
	$options->def('Help');
	$options->description("Simple script demonstrating PhpOptions\nauthor: Viktor Masicek <viktor@masicek.net>");
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

$name = $options->get('Name');
if ($name)
{
	echo $name . "\n";
}

$homeDir = $options->get('Home');
if ($homeDir)
{
	echo $homeDir . "\n";
}

$favoriteCollor = $options->get('-f');
if ($favoriteCollor)
{
	echo $favoriteCollor . "\n";
}

$eyeColor = $options->get('--color-of-eye');
if ($eyeColor)
{
	echo $eyeColor . "\n";
}
