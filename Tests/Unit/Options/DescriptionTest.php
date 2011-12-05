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

/**
 * DescriptionTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Options::description
 */
class DescriptionTest extends TestCase
{

	public function test()
	{
		$options = new Options();
		$this->assertInstanceOf('\PhpOptions\Options', $options->description('Lorem ipsum'));
		$this->assertRegExp('/Lorem ipsum/', $options->getHelp());
	}

}
