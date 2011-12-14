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
	}


	public function testMore()
	{
		$options = new Options();
		$options->add(Option::make('Foo'));
		$options->add(Option::make('Bar'));
		$this->assertInstanceOf('PhpOptions\Options', $options->group('Lorem ipsum', array('Foo', 'Bar')));
	}


}
