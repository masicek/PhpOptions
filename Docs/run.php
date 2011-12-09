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

// generate documentation
exec('php '. __DIR__ . '/Apigen/apigen.php --title PhpOptions --source ' . __DIR__ . '/../Types --source ' . __DIR__ . '/../Arguments.php --source ' . __DIR__ . '/../Option.php --source ' . __DIR__ . '/../Options.php --source ' . __DIR__ . '/../Exceptions.php --todo yes --destination ' . __DIR__ . '/Data');
