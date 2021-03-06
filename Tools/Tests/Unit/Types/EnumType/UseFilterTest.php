<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\EnumType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\EnumType;

require_once ROOT . '/Types/EnumType.php';

/**
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\EnumType::useFilter
 */
class UseFilterTest extends TestCase
{


	public function testWithoutKeys()
	{
		$type = new EnumType(array(array('first', 'second')));
		$filteredValue = $type->filter('first');
		$this->assertEquals(0, $filteredValue);
		$filteredValue = $type->filter('second');
		$this->assertEquals(1, $filteredValue);
	}


	public function testWithKeys()
	{
		$type = new EnumType(array(array('a' => 'first', 'b' => 'second')));
		$filteredValue = $type->filter('first');
		$this->assertEquals('a', $filteredValue);
		$filteredValue = $type->filter('second');
		$this->assertEquals('b', $filteredValue);
	}


}
