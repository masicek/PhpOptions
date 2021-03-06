<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\DatetimeType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\DatetimeType;

require_once ROOT . '/Types/DatetimeType.php';

/**
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\DatetimeType::useFilter
 */
class UseFilterTest extends TestCase
{


	public function testDatetime()
	{
		$type = new DatetimeType();
		$filteredValue = $type->filter('2010-dec-10 12:50:10');
		$this->assertInstanceOf('\DateTime', $filteredValue);
		$this->assertEquals(strtotime('10-12-2010 12:50:10'), $filteredValue->getTimestamp());
	}


	public function testTimestamp()
	{
		$type = new DatetimeType(array('timestamp'));
		$filteredValue = $type->filter('2010-dec-10 12:50:10');
		$this->assertTrue(is_int($filteredValue));
		$this->assertEquals(strtotime('10-12-2010 12:50:10'), $filteredValue);
	}


}
