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
 * ShortLongTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Option::short
 * @covers PhpOptions\Option::long
 */
class ShortLongTest extends TestCase
{


	public function testDefault()
	{
		$option = Option::make('Foo  bar--option');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals('f', $option->getShort());
		$this->assertEquals('foo-bar-option', $option->getLong());
	}


	public function testEmptyShort()
	{
		$option = Option::make('Foo bar')->short();
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertNull($option->getShort());
		$this->assertEquals('foo-bar', $option->getLong());
	}


	public function testShort()
	{
		$option = Option::make('Foo bar')->short('x');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals('x', $option->getShort());
		$this->assertEquals('foo-bar', $option->getLong());
	}


	public function testShortManyCharacters()
	{
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$option = Option::make('Foo bar')->short('xy');
	}


	public function testEmptyLong()
	{
		$option = Option::make('Foo bar')->long();
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertNull($option->getLong());
		$this->assertEquals('f', $option->getShort());
	}


	public function testLong()
	{
		$option = Option::make('Foo bar')->long('my-foo_bar');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals('f', $option->getShort());
		$this->assertEquals('my-foo_bar', $option->getLong());
	}


	public function testEmptyShortAndLong()
	{
		$this->setExpectedException('\PhpOptions\LogicException');
		$option = Option::make('Foo bar')->short()->long();
	}


	public function testEmptyLongAndShort()
	{
		$this->setExpectedException('\PhpOptions\LogicException');
		$option = Option::make('Foo bar')->long()->short();
	}


}
