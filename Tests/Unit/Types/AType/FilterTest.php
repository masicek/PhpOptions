<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\AType;

use \Tests\PhpOptions\TestCase;

require_once 'FooType.php';
require_once ROOT .'/Types/StringType.php';

/**
 * FilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\AType::filter
 * @covers PhpOptions\Types\AType::useFilter
 * @covers Tests\PhpOptions\Types\AType\FooType::useFilter
 */
class FilterTest extends TestCase
{


	public function testUseFilter()
	{
		$type = new FooType();
		$this->assertEquals('Test filtered value', $type->filter('Lorem ipsum'));
	}


	public function testUseFilterParent()
	{
		$type = new \PhpOptions\Types\StringType();
		$this->assertEquals('Lorem ipsum', $type->filter('Lorem ipsum'));
	}


	public function testNotUseFilter()
	{
		$type = new FooType(array('notFilter'));
		$this->assertEquals('Lorem ipsum', $type->filter('Lorem ipsum'));
	}


}
