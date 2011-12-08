<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types;

require_once ROOT . '/Types/Types.php';

/**
 * RegisterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types::register
 */
class RegisterTest extends TestCase
{


	public function test()
	{
		$types = new Types();
		$types->register('Foo', '\Tests\PhpOptions\Types\FooType', __DIR__ . '/FooType.php');

		$registeredTpes = $this->getPropertyValue($types, 'registeredTypes');
		$this->assertEquals('\Tests\PhpOptions\Types\FooType', $registeredTpes['foo']['className']);
		$this->assertEquals(__DIR__ . '/FooType.php', $registeredTpes['foo']['classPath']);
	}


}
