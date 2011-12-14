<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\AType;

use \Tests\PhpOptions\TestCase;

require_once 'FooType.php';

/**
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\AType::check
 */
class CheckTest extends TestCase
{

	public function test()
	{
		$type = new FooType();
		$this->assertTrue($type->check('lorem'));
	}

}
