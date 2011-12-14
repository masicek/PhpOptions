<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions;

use \Tests\PhpOptions\TestCase;

/**
 * RegisterTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Option::registerType
 * @covers PhpOptions\Option::getTypes
 * @covers Tests\PhpOptions\Option\FooType
 */
class RegisterTypeTest extends TestCase
{


	public function testNew()
	{
		\PhpOptions\Option::registerType('foo', '\Tests\PhpOptions\Option\FooType', __DIR__ . '/FooType.php');
		$option = \PhpOptions\Option::foo('Foo');
		$type = $this->getPropertyValue($option, 'type');
		$this->assertInstanceOf('\Tests\PhpOptions\Option\FooType', $type);
	}


	public function testRedefine()
	{
		\PhpOptions\Option::registerType('integer', '\Tests\PhpOptions\Option\FooType', __DIR__ . '/FooType.php');
		$option = \PhpOptions\Option::integer('Foo');
		$type = $this->getPropertyValue($option, 'type');
		$this->assertInstanceOf('\Tests\PhpOptions\Option\FooType', $type);
	}


}
