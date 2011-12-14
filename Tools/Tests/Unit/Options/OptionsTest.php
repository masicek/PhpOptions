<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Options;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Options;

require_once ROOT . '/Options.php';
require_once ROOT . '/Exceptions.php';

/**
 * OptionsTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Options::__construct
 */
class OptionsTest extends TestCase
{


	public function testConsole()
	{
		$options = new Options();
		$this->assertTrue(TRUE);
	}


}
