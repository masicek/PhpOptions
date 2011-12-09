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
 * DescriptionTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Option::description
 */
class DescriptionTest extends TestCase
{


	public function testDefault()
	{
		$option = Option::make('Foo');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals('', $this->getPropertyValue($option, 'description'));
	}


	public function testSetDescription()
	{
		$option = Option::make('Foo')->description('Lorem ipsum');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertEquals('Lorem ipsum', $this->getPropertyValue($option, 'description'));
	}


}
