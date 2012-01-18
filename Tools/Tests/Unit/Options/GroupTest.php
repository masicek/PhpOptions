<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
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
 * GroupTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Options::group
 * @covers PhpOptions\Options::dependences
 */
class GroupTest extends TestCase
{


	public function testAlreadyExistsGroup()
	{
		$options = new Options();
		$options->add(Option::make('Foo'));
		$options->add(Option::make('Bar'));
		$options->group('Lorem ipsum', 'Foo');
		$this->setExpectedException('PhpOptions\LogicException');
		$options->group('Lorem ipsum', 'Bar');
	}


	public function testUnknownOne()
	{
		$options = new Options();
		$this->setExpectedException('PhpOptions\LogicException');
		$options->group('Lorem ipsum', 'Foo');
	}


	public function testUnknownMore()
	{
		$options = new Options();
		$this->setExpectedException('PhpOptions\LogicException');
		$options->group('Lorem ipsum', array('Foo', 'Bar'));
	}


	public function testOne()
	{
		$options = new Options();
		$options->add(Option::make('Foo'));
		$this->assertInstanceOf('PhpOptions\Options', $options->group('Lorem ipsum', 'Foo'));
		$this->assertEquals(array('Lorem ipsum' => array('Foo')), $this->getPropertyValue($options, 'groups'));
	}


	public function testMore()
	{
		$options = new Options();
		$options->add(Option::make('Foo'));
		$options->add(Option::make('Bar'));
		$this->assertInstanceOf('PhpOptions\Options', $options->group('Lorem ipsum', array('Foo', 'Bar')));
		$this->assertEquals(array('Lorem ipsum' => array('Foo', 'Bar')), $this->getPropertyValue($options, 'groups'));
	}


	public function testByDependences()
	{
		$options = new Options();
		$options->add(Option::make('Foo'));
		$options->add(Option::make('Bar'));
		$this->assertInstanceOf('PhpOptions\Options', $options->dependences('Foo', array('Bar'), 'Lorem ipsum'));
		$this->assertEquals(array('Lorem ipsum' => array('Foo', 'Bar')), $this->getPropertyValue($options, 'groups'));
	}


	public function testNotByDependences()
	{
		$options = new Options();
		$options->add(Option::make('Foo'));
		$options->add(Option::make('Bar'));
		$this->assertInstanceOf('PhpOptions\Options', $options->dependences('Foo', array('Bar')));
		$this->assertEquals(array(), $this->getPropertyValue($options, 'groups'));
	}


}
