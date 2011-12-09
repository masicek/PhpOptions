<?php

/**
 * PhpOptions
 *
 * Make minified version of PhpOptions for better manipulation and including.
 *
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

// path to minified classes
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'PhpOptions');

// get default types
require_once ROOT . '/Types/Types.php';
$types = new \PhpOptions\Types();
$defaultTypes = $types->getDefaultTypes();


// list of all files
$files = array();
$files[] = ROOT . '/Arguments.php';
$files[] = ROOT . '/Exceptions.php';
$files[] = ROOT . '/Option.php';
$files[] = ROOT . '/Options.php';
$files[] = ROOT . '/Types/AType.php';
$files[] = ROOT . '/Types/Types.php';
foreach ($defaultTypes as $type)
{
	$files[] = $type['classPath'];
}


// generate all mini
$content = '';
foreach ($files as $file)
{
	$fileContent = exec('php -w ' . $file);
	// remove all require_once
	$fileContent = preg_replace('/require_once[^;]+;/', '', $fileContent);
	$content .= $fileContent . ' ';
	fwrite(STDOUT, 'Generated: ' . $file . "\n");
}

// set default types
//private static $serializedDeafultTypes = '';
$content = str_replace(
	'private static $serializedDeafultTypes = \'\';',
	'private static $serializedDeafultTypes = \'' . serialize($defaultTypes) . '\';',
	$content
);
fwrite(STDOUT, "Default types set\n");


// comment with licence atc.
require_once ROOT . '/Options.php';
$comment = '/** PhpOptions-' . PhpOptions\Options::VERSION . ', Minified version of PhpOptions. @link git@github.com:masicek/PhpOptions.git @author Viktor Mašíček <viktor@masicek.net> @license "New" BSD License */';
fwrite(STDOUT, "Comment added\n");


// save into file
$content = '<?php ' . $comment . ' ' . $content;
$fileMini = fopen(__DIR__ . '/PhpOptions.min.php', 'w');
fwrite($fileMini, $content);

fwrite(STDOUT, 'Minified file was generated');
