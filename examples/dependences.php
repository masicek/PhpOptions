<?php

/**
 * This script print your name, if you set them by option '-n' or '--name'.
 * "Name" option is require.
 *
 * Possible using:
 * php dependences.php
 * php dependences.php --surname="Novak"
 * php dependences.php --first-name="Jan" --surname="Novak"
 * php dependences.php --degree="Mgr." --first-name="Jan" --surname="Novak" --school="Charles University"
 *
 * Exception terminated:
 * php dependences.php --first-name="Jan"
 * php dependences.php --degree="Mgr."
 */

require_once __DIR__ . '/../Options.php';
require_once __DIR__ . '/../Option.php';

use PhpOptions\Options;
use PhpOptions\Option;


// define options
try {
	$optionsList = array();
	$optionsList[] = Option::make('Surname')->value()->description('Surname of user');
	$optionsList[] = Option::make('First name')->value()->description('First name of user');
	$optionsList[] = Option::make('School')->short('c')->value()->description('School where user studied');
	$optionsList[] = Option::make('Degree')->value()->description('Degree of user');

	$options = new Options();
	$options->add($optionsList);
	$options->description('Information about user');
	$options->dependences('First name', 'Surname');
	$options->dependences('Degree', array('First name', 'School'));
} catch (Exception $e) {
	echo $e->getMessage();
	die();
}


// using options
$firstName = $options->get('First name');
$surname = $options->get('Surname');
$school = $options->get('School');
$degree = $options->get('Degree');
if ($degree)
{
	echo "$firstName $surname has a $degree degree at the $school.";
}
elseif ($firstName)
{
	echo "Full name is $firstName $surname";
}
elseif ($surname)
{
	echo "Surname is $surname";
}
else
{
	echo $options->getHelp();
}
