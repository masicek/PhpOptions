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
exec('php '. __DIR__ . '/Apigen/apigen.php --title PhpOptions --source ' . __DIR__ . '/../PhpOptions --todo yes --destination ' . __DIR__ . '/Data');
