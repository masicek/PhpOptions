<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Option;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Option;

require_once ROOT . '/Option.php';
require_once ROOT . '/Exceptions.php';

/**
 * ValueDefTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Option::value
 * @covers PhpOptions\Option::def
 * @covers PhpOptions\Option::getDef
 */
class ValueDefTest extends TestCase
{


	public function testDefaultValueNoValue()
	{
		$this->setExpectedException('\PhpOptions\LogicException');
		$option = Option::make('Foo')->def('Lorem ipsum');
	}


	public function testDefaultValueRequiredValue()
	{
		$this->setExpectedException('\PhpOptions\LogicException');
		$option = Option::make('Foo')->value()->def('Lorem ipsum');
	}


	public function testRequiredValueDefaultValue()
	{
		$this->setExpectedException('\PhpOptions\LogicException');
		$option = Option::make('Foo')->value(FALSE)->def('Lorem ipsum')->value();
	}


	public function testNoValue()
	{
		$option = Option::make('Foo');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals(Option::VALUE_NO, $this->getPropertyValue($option, 'valueRequired'));
	}


	public function testRequiredValue()
	{
		$option = Option::make('Foo')->value();
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals(Option::VALUE_REQUIRE, $this->getPropertyValue($option, 'valueRequired'));
	}


	public function testOptionalValue()
	{
		$option = Option::make('Foo')->value(FALSE);
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals(Option::VALUE_OPTIONAL, $this->getPropertyValue($option, 'valueRequired'));
	}


	public function testNoDefaultValue()
	{
		$option = Option::make('Foo');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals(NULL, $option->getDef());
	}


	public function testSetDefaultValue()
	{
		$option = Option::make('Foo')->value(FALSE)->def('Lorem ipsum');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals('Lorem ipsum', $option->getDef());
	}


}
