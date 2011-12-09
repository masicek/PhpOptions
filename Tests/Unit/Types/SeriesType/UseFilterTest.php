<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\SeriesType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\SeriesType;

require_once ROOT . '/Types/SeriesType.php';

/**
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\SeriesType::useFilter
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
