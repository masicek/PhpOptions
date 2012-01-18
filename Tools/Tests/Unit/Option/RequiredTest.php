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
 * RequiredTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Option::required
 */
class RequiredTest extends TestCase
{


	public function testDefault()
	{
		$option = Option::make('Foo');
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertFalse($this->getPropertyValue($option, 'required'));
	}


	public function testIsRequired()
	{
		$option = Option::make('Foo')->required();
		$this->assertInstanceOf('\PhpOptions\Option', $option);
		$this->assertTrue($this->getPropertyValue($option, 'required'));
	}


	public function testRequiredValueDefaultsValueRequiredOption()
	{
		$this->setExpectedException('\PhpOptions\LogicException');
		$option = Option::make('Foo')->value()->defaults('Lorem ipsum')->required();
	}


}
