<?php

/**
 * PhpOptions
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
 * @covers PhpOptions\Option::defaults
 * @covers PhpOptions\Option::getDefaults
 */
class ValueDefTest extends TestCase
{


	public function testDefaultsValueNoValue()
	{
		$this->setExpectedException('\PhpOptions\LogicException');
		$option = Option::make('Foo')->defaults('Lorem ipsum');
	}


	public function testDefaultsValueRequiredValue()
	{
		$this->setExpectedException('\PhpOptions\LogicException');
		$option = Option::make('Foo')->value()->defaults('Lorem ipsum');
	}


	public function testRequiredValueDefaultValue()
	{
		$this->setExpectedException('\PhpOptions\LogicException');
		$option = Option::make('Foo')->value(FALSE)->defaults('Lorem ipsum')->value();
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
		$this->assertEquals(NULL, $option->getDefaults());
	}


	public function testSetDefaultValue()
	{
		$option = Option::make('Foo')->value(FALSE)->defaults('Lorem ipsum');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals('Lorem ipsum', $option->getDefaults());
	}


}
