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
 * AddTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Options::add
 * @covers PhpOptions\Options::addOne
 * @covers PhpOptions\Options::checkConflicts
 */
class AddTest extends TestCase
{


	public function testOneOption()
	{
		$this->setArguments('--foo lorem');
		$options = new Options();
		$option = Option::make('Foo')->value();
		$this->assertInstanceOf('\PhpOptions\Options', $options->add($option));
		$this->assertEquals('lorem', $options->get('Foo'));

		$this->assertEquals(array('Foo' => $option), $this->getPropertyValue($options, 'options'));
		$this->assertEquals(array('Foo' => 'lorem'), $this->getPropertyValue($options, 'optionsValues'));
		$this->assertEquals(array('f' => 'Foo'), $this->getPropertyValue($options, 'optionsShorts'));
		$this->assertEquals(array('foo' => 'Foo'), $this->getPropertyValue($options, 'optionsLongs'));
	}


	public function testMoreOptions()
	{
		$this->setArguments('--foo lorem -b');
		$options = new Options();
		$option1 = Option::make('Foo')->value()->short();
		$option2 = Option::make('Bar')->value(FALSE)->long();
		$this->assertInstanceOf('\PhpOptions\Options', $options->add(array($option1, $option2)));
		$this->assertEquals('lorem', $options->get('Foo'));

		$this->assertEquals(array('Foo' => $option1, 'Bar' => $option2), $this->getPropertyValue($options, 'options'));
		$this->assertEquals(array('Foo' => 'lorem', 'Bar' => TRUE), $this->getPropertyValue($options, 'optionsValues'));
		$this->assertEquals(array('b' => 'Bar'), $this->getPropertyValue($options, 'optionsShorts'));
		$this->assertEquals(array('foo' => 'Foo'), $this->getPropertyValue($options, 'optionsLongs'));
	}


	public function testExistName()
	{
		$options = new Options();
		$option1 = Option::make('Foo');
		$option2 = Option::make('Foo');
		$this->setExpectedException('\PhpOptions\LogicException');
		$options->add(array($option1, $option2));
	}


	public function testExistShort()
	{
		$options = new Options();
		$option1 = Option::make('Foo');
		$option2 = Option::make('Foo2');
		$this->setExpectedException('\PhpOptions\LogicException');
		$options->add(array($option1, $option2));
	}


	public function testExistLong()
	{
		$options = new Options();
		$option1 = Option::make('Foo-bar')->short();
		$option2 = Option::make('Foo bar');
		$this->setExpectedException('\PhpOptions\LogicException');
		$options->add(array($option1, $option2));
	}


}
