<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
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


	public function testNonConsole()
	{
		$this->markTestSkipped('It cannot be simulating of running the csript from another intergace then CLI.');

		$this->setExpectedException('PhpOptions\UserBadCallException');
		$options = new Options();
	}


}
