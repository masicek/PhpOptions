<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Options;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Options;

require_once ROOT . '/Options.php';

/**
 * ArgumentsTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Options::arguments
 */
class ArgumentsTest extends TestCase
{


	public function test()
	{
		$this->setArguments('-abc lorem ipsum --foo bar car');
		$this->assertEquals(array('ipsum', 'car'), Options::arguments());
	}


}
