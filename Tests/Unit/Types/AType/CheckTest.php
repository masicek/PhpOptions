<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\AType;

use \Tests\PhpOptions\TestCase;

require_once 'FooType.php';

/**
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\AType::check
 */
class CheckTest extends TestCase
{

	public function test()
	{
		$type = new FooType();
		$this->assertTrue($type->check('lorem'));
	}

}
