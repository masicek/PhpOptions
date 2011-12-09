<?php

/*
 * PhpOptions
 *
 * Generate API documentation
 *
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

// path to documented classes
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..');

// generate documentation
exec('php '. ROOT . '/Docs/Apigen/apigen.php --source ' . ROOT . '/Types --source ' . ROOT . '/Arguments.php --source ' . ROOT . '/Option.php --source ' . ROOT . '/Options.php --source ' . ROOT . '/Exceptions.php --todo yes --destination ' . ROOT . '/Docs/Data');
