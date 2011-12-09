<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\AType;

use \Tests\PhpOptions\TestCase;

require_once 'FooType.php';

/**
 * GetNameTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\AType::getName
 */
class GetNameTest extends TestCase
{


	public function test()
	{
		$type = new FooType();
		$this->assertEquals('FOO', $type->getName());
	}


}
