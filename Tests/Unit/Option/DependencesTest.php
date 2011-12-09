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
 * DependencesTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Option::dependences
 */
class DependencesTest extends TestCase
{


	public function testDefault()
	{
		$option = Option::make('Foo');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals(array(), $this->getPropertyValue($option, 'needed'));
	}


	public function testSetDependences()
	{
		$option = Option::make('Foo')->dependences(array('bar', 'foobar'));
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals(array('bar', 'foobar'), $this->getPropertyValue($option, 'needed'));
	}


}
