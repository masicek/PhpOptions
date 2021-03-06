<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\DateType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\DateType;

require_once ROOT . '/Types/DateType.php';

/**
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\DateType::useFilter
 */
class UseFilterTest extends TestCase
{


	public function testDatetime()
	{
		$type = new DateType();
		$filteredValue = $type->filter('2010-dec-10');
		$this->assertInstanceOf('\DateTime', $filteredValue);
		$this->assertEquals(strtotime('10-12-2010 00:00:00'), $filteredValue->getTimestamp());
	}


	public function testTimestamp()
	{
		$type = new DateType(array('timestamp'));
		$filteredValue = $type->filter('2010-dec-10');
		$this->assertTrue(is_int($filteredValue));
		$this->assertEquals(strtotime('10-12-2010 00:00:00'), $filteredValue);
	}


}
