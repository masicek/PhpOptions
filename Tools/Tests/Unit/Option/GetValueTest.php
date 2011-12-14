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
 * GetValueTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Option::getValue
 * @covers PhpOptions\Option::readValue
 */
class GetValueTest extends TestCase
{


	public function testShortAndLongTogether()
	{
		$this->setArguments('-f --foo');
		$option = Option::make('foo');
		$this->setExpectedException('\PhpOptions\UserBadCallException');
		$option->getValue();
	}


	public function testNoShortAndNoLongAndNotReuired()
	{
		$this->setArguments('');
		$option = Option::make('foo');
		$this->assertFalse($option->getValue());
	}


	public function testShortWithoutValue()
	{
		$this->setArguments('-f');
		$option = Option::make('foo');
		$this->assertTrue($option->getValue());
	}


	public function testLongWithoutValue()
	{
		$this->setArguments('--foo');
		$option = Option::make('foo');
		$this->assertTrue($option->getValue());
	}


	public function testShortWithValue()
	{
		$this->setArguments('-f lorem');
		$option = Option::make('foo')->value();
		$this->assertEquals('lorem', $option->getValue());
	}


	public function testLongWithValue()
	{
		$this->setArguments('--foo lorem');
		$option = Option::make('foo')->value();
		$this->assertEquals('lorem', $option->getValue());
	}


	public function testRequiredAndNotSet()
	{
		$this->setArguments('');
		$option = Option::make('foo')->required();
		$this->setExpectedException('\PhpOptions\UserBadCallException');
		$option->getValue();
	}


	public function testRequiredAndNotSetAndDefualtOptionSet()
	{
		$this->setArguments('');
		$option = Option::make('foo')->required();
		$this->assertFalse($option->getValue(TRUE));
	}


	public function testNoValue()
	{
		$this->setArguments('-f');
		$option = Option::make('foo');
		$this->assertTrue($option->getValue());
	}


	public function testNoValueAndValueSet()
	{
		$this->setArguments('-f lorem');
		$option = Option::make('foo');
		$this->setExpectedException('\PhpOptions\UserBadCallException');
		$option->getValue();
	}


	public function testOptionalValueAndValueNotSet()
	{
		$this->setArguments('-f');
		$option = Option::make('foo')->value(FALSE);
		$this->assertTrue($option->getValue());
	}


	public function testOptionalValueAndValueNotSetAndDefaultsSet()
	{
		$this->setArguments('-f');
		$option = Option::make('foo')->value(FALSE)->defaults('lorem');
		$this->assertEquals('lorem', $option->getValue());
	}


	public function testOptionalValueAndValueSet()
	{
		$this->setArguments('-f lorem');
		$option = Option::make('foo')->value(FALSE);
		$this->assertEquals('lorem', $option->getValue());
	}


	public function testOptionalValueAndValueSetAndDefaultsSet()
	{
		$this->setArguments('-f lorem');
		$option = Option::make('foo')->value(FALSE)->defaults('ipsum');
		$this->assertEquals('lorem', $option->getValue());
	}


	public function testRequireValueAndValueNotSet()
	{
		$this->setArguments('-f');
		$option = Option::make('foo')->value();
		$this->setExpectedException('\PhpOptions\UserBadCallException');
		$option->getValue();
	}


	public function testRequireValueAndValueSet()
	{
		$this->setArguments('-f lorem');
		$option = Option::make('foo')->value();
		$this->assertEquals('lorem', $option->getValue());
	}


	public function testTypeFilterValue()
	{
		$this->setArguments('-f second');
		$option = Option::enum('foo', array('f' => 'first', 's' => 'second'));
		$this->assertEquals('s', $option->getValue());
	}


	public function testTypeNotFilterValue()
	{
		$this->setArguments('-f second');
		$option = Option::enum('foo', 'notFilter', array('f' => 'first', 's' => 'second'));
		$this->assertEquals('second', $option->getValue());
	}


	public function testTypeFilterValueAndBadFormat()
	{
		$this->setArguments('-f lorem');
		$option = Option::enum('foo', array('f' => 'first', 's' => 'second'));
		$this->setExpectedException('\PhpOptions\UserBadCallException');
		$option->getValue();
	}


	public function testTypeNotFilterValueAndBadFormat()
	{
		$this->setArguments('-f lorem');
		$option = Option::enum('foo', 'notFilter', array('f' => 'first', 's' => 'second'));
		$this->setExpectedException('\PhpOptions\UserBadCallException');
		$option->getValue();
	}


}
