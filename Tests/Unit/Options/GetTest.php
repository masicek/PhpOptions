<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Options;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Options;
use \PhpOptions\Option;

require_once ROOT . '/Options.php';
require_once ROOT . '/Option.php';
require_once ROOT . '/Exceptions.php';

/**
 * GetTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Options::get
 */
class GetTest extends TestCase
{


	public function testUnknownName()
	{
		$options = new Options();
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$options->get('Foo');
	}


	public function testUnknownShort()
	{
		$options = new Options();
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$options->get('-f');
	}


	public function testUnknownLong()
	{
		$options = new Options();
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$options->get('--foo');
	}


	public function testName()
	{
		$this->setArguments('--foo lorem');
		$options = new Options();
		$options->add(Option::make('Foo')->value());
		$this->assertEquals('lorem', $options->get('Foo'));
	}


	public function testShort()
	{
		$this->setArguments('--foo lorem');
		$options = new Options();
		$options->add(Option::make('Foo')->value());
		$this->assertEquals('lorem', $options->get('-f'));
	}


	public function testLong()
	{
		$this->setArguments('--foo lorem');
		$options = new Options();
		$options->add(Option::make('Foo')->value());
		$this->assertEquals('lorem', $options->get('--foo'));
	}


	public function testNameDefault()
	{
		$this->setArguments('');
		$options = new Options();
		$options->add(Option::make('Foo')->value(FALSE)->defaults('ipsum'));
		$this->assertEquals('ipsum', $options->get('Foo'));
	}


	public function testShortDefault()
	{
		$this->setArguments('');
		$options = new Options();
		$options->add(Option::make('Foo')->value(FALSE)->defaults('ipsum'));
		$this->assertEquals('ipsum', $options->get('-f'));
	}


	public function testLongDefault()
	{
		$this->setArguments('');
		$options = new Options();
		$options->add(Option::make('Foo')->value(FALSE)->defaults('ipsum'));
		$this->assertEquals('ipsum', $options->get('--foo'));
	}


	public function testDefaultOption()
	{
		$this->setArguments('');
		$options = new Options();
		$options->add(Option::make('Foo'));
		$options->defaults('Foo');
		$this->assertEquals(TRUE, $options->get('Foo'));
	}


}
