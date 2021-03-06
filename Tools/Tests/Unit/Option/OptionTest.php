<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Option;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Option;

require_once ROOT . '/Option.php';
require_once ROOT . '/Exceptions.php';

/**
 * OptionTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Option::__construct
 * @covers PhpOptions\Option::getName
 * @covers PhpOptions\Option::getShort
 * @covers PhpOptions\Option::getLong
 * @covers PhpOptions\Option::make
 * @covers PhpOptions\Option::__callStatic
 * @covers PhpOptions\Option::getTypes
 */
class OptionTest extends TestCase
{


	public function testEmptyNameByConstruct()
	{
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$option = new Option('');
	}


	public function testEmptyNameByMake()
	{
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$option = Option::make('');
	}


	public function testEmptyNameByType()
	{
		$this->setPropertyValue('Option', '\PhpOptions\Option::$types', NULL);
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$option = Option::string('');
	}


	public function testByConstruct()
	{
		$option = new Option('Foo  Bar-option');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals('Foo  Bar-option', $option->getName());
		$this->assertEquals('f', $option->getShort());
		$this->assertEquals('foo-bar-option', $option->getLong());
		$this->assertNull($this->getPropertyValue($option, 'type'));
	}


	public function testByMake()
	{
		$option = Option::make('Foo  Bar-option');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals('Foo  Bar-option', $option->getName());
		$this->assertEquals('f', $option->getShort());
		$this->assertEquals('foo-bar-option', $option->getLong());
		$this->assertNull($this->getPropertyValue($option, 'type'));
	}


	public function testByType()
	{
		$option = Option::string('Foo  Bar-option');
		$this->assertEquals('Foo  Bar-option', $option->getName());
		$this->assertEquals('f', $option->getShort());
		$this->assertEquals('foo-bar-option', $option->getLong());
		$type = $this->getPropertyValue($option, 'type');
		$this->assertInstanceOf('\PhpOptions\Types\StringType', $type);
	}


	public function testByTypeWithSetting()
	{
		$option = Option::string('Foo  Bar-option', 'notFilter');
		$this->assertEquals('Foo  Bar-option', $option->getName());
		$this->assertEquals('f', $option->getShort());
		$this->assertEquals('foo-bar-option', $option->getLong());
		$type = $this->getPropertyValue($option, 'type');
		$this->assertInstanceOf('\PhpOptions\Types\StringType', $type);
		$this->assertFalse($this->getPropertyValue($type, 'useFilter'));
	}


	public function testUnknownType()
	{
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$option = Option::unknown('Foo');
	}


}
