<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\Types;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\Types;

require_once ROOT . '/Types/Types.php';
require_once ROOT . '/Exceptions.php';

/**
 * GetTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\Types::getType
 */
class GetTypeTest extends TestCase
{


	public function testDefaultType()
	{
		$types = new Types();
		$type = $types->getType('string', array());
		$this->assertInstanceOf('\PhpOptions\Types\AType', $type);
		$this->assertInstanceOf('\PhpOptions\Types\StringType', $type);
	}


	/**
	 * @covers Tests\PhpOptions\Types\Types\FooType
	 */
	public function testOwnType()
	{
		$types = new Types();
		$types->register('Foo', '\Tests\PhpOptions\Types\Types\FooType', __DIR__ . '/FooType.php');
		$type = $types->getType('foo', array());
		$this->assertInstanceOf('\PhpOptions\Types\AType', $type);
		$this->assertInstanceOf('\Tests\PhpOptions\Types\Types\FooType', $type);
	}


	/**
	 * @covers Tests\PhpOptions\Types\Types\BarType
	 */
	public function testWrongType()
	{
		$types = new Types();
		$types->register('bar', '\Tests\PhpOptions\Types\Types\BarType', __DIR__ . '/BarType.php');
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$type = $types->getType('bar', array());
	}


	public function testUnknownType()
	{
		$types = new Types();
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$type = $types->getType('unknown', array());
	}


}
