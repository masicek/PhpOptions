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
 * DependencesTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Options::dependences
 */
class DependencesTest extends TestCase
{


	public function testMainUnknown()
	{
		$options = new Options();
		$options->add(Option::make('Bar'));
		$this->setExpectedException('PhpOptions\InvalidArgumentException');
		$options->dependences('Foo', 'Bar');
	}


	public function testNeededUnknownOne()
	{
		$options = new Options();
		$options->add(Option::make('Foo'));
		$this->setExpectedException('PhpOptions\InvalidArgumentException');
		$options->dependences('Foo', 'Bar');
	}


	public function testNeededUnknownMore()
	{
		$options = new Options();
		$options->add(Option::make('Foo'));
		$this->setExpectedException('PhpOptions\InvalidArgumentException');
		$options->dependences('Foo', array('Bar1', 'Bar2'));
	}


	public function testNeededOptionHasNotValue()
	{
		$this->setArguments('-f');
		$options = new Options();
		$options->add(Option::make('Foo'));
		$options->add(Option::make('Bar'));
		$this->setExpectedException('PhpOptions\UserBadCallException');
		$options->dependences('Foo', 'Bar');
	}


	public function testMainAndNeededOptionsHasNotValues()
	{
		$options = new Options();
		$foo = Option::make('Foo');
		$options->add($foo);
		$bar = Option::make('Bar');
		$options->add($bar);
		$this->assertInstanceOf('PhpOptions\Options', $options->dependences('Foo', 'Bar'));
		$this->assertEquals(array($bar), $this->getPropertyValue($foo, 'needed'));
		$this->assertEquals(array(), $this->getPropertyValue($bar, 'needed'));
	}


	public function testNeededOne()
	{
		$this->setArguments('-f -b lorem');
		$options = new Options();
		$foo = Option::make('Foo');
		$options->add($foo);
		$bar = Option::make('Bar')->value();
		$options->add($bar);
		$this->assertInstanceOf('PhpOptions\Options', $options->dependences('Foo', 'Bar'));
		$this->assertEquals(array($bar), $this->getPropertyValue($foo, 'needed'));
		$this->assertEquals(array(), $this->getPropertyValue($bar, 'needed'));
	}


	public function testNeededMore()
	{
		$this->setArguments('-f -b lorem -c ipsum');
		$options = new Options();
		$foo = Option::make('Foo');
		$options->add($foo);
		$bar = Option::make('Bar')->value();
		$options->add($bar);
		$car = Option::make('Car')->value();
		$options->add($car);
		$this->assertInstanceOf('PhpOptions\Options', $options->dependences('Foo', array('Bar', 'Car')));
		$this->assertEquals(array($bar, $car), $this->getPropertyValue($foo, 'needed'));
		$this->assertEquals(array(), $this->getPropertyValue($bar, 'needed'));
	}


}
