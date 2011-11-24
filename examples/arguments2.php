<?php

/**
 * This script print all arguments from coman-line (not options).
 *
 * Possible using:
 * php arguments2.php -a aaa bbb ccc -> print: bbb,ccc
 * php arguments2.php -ab aaa bbb ccc -> print: bbb,ccc
 * php arguments2.php -a aaa -b bbb ccc -> print: ccc
 * php arguments2.php -a aaa -b bbb -c ccc -> print: ANY ARGUMENTS
 */

require_once __DIR__ . '/../Arguments.php';

use PhpOptions\Arguments;

$arguments = Arguments::arguments();
if (count($arguments) > 0)
{
	echo implode(',', $arguments);
}
else
{
	echo 'ANY ARGUMENTS';
}
