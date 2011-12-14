<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\SeriesType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\SeriesType;

require_once ROOT . '/Types/SeriesType.php';

/**
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\SeriesType::useFilter
 */
class UseFilterTest extends TestCase
{


	public function testDefaultDelimiters()
	{
		$type = new SeriesType();
		$filteredValue = $type->filter('first second|third,fourth;fifth');
		$this->assertInternalType('array', $filteredValue);
		$this->assertEquals(array('first', 'second', 'third', 'fourth', 'fifth'), $filteredValue);
	}


	public function testSetDelimiters()
	{
		$type = new SeriesType(array('*#'));
		$filteredValue = $type->filter('first second#third,fourth*fifth');
		$this->assertInternalType('array', $filteredValue);
		$this->assertEquals(array('first second', 'third,fourth', 'fifth'), $filteredValue);
	}


}
