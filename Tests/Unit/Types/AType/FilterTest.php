<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\AType;

use \Tests\PhpOptions\TestCase;

require_once 'FooType.php';

/**
 * FilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\AType::filter
 */
class FilterTest extends TestCase
{


	public function testUseFilter()
	{
		$type = new FooType();
		$this->assertEquals('Test filtered value', $type->filter('Lorem ipsum'));
	}


	public function testNotUseFilter()
	{
		$type = new FooType(array('notFilter'));
		$this->assertEquals('Lorem ipsum', $type->filter('Lorem ipsum'));
	}


}
