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
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\DatetimeType::check
 * @covers PhpOptions\Types\DatetimeType::getDatetimeString
 * @covers PhpOptions\Types\DatetimeType::complete
 */
class CheckTest extends TestCase
{


	/**
	 * @dataProvider provider
	 */
	public function test($value, $exceptOk)
	{
		$type = new DatetimeType();
		if ($exceptOk)
		{
			$this->assertTrue($type->check($value));
		}
		else
		{
			$this->assertFalse($type->check($value));
		}
	}


	/**
	 * Provider for self::test
	 */
	public function provider()
	{
		return array(
			array('2000-03-20', TRUE),
			array('2001.2-5', TRUE),
			array('2002-dec.12', TRUE),
			array('2003.2.5   12', TRUE),
			array('2004.2.5 12:5', TRUE),
			array('2005.2.5 12:20:5', TRUE),
			array('2006.dec.5 12:2:50', TRUE),
			array('2007.dec.5 12:2:50 P', TRUE),
			array('2008.dec.5 10:2:50 A', TRUE),
			array('2009.dec.5 10:2:50 am', TRUE),
			array('2010-06.5 10:02:50 PM', TRUE),
			array('aaa', FALSE),
			array('210', FALSE),
			array('2100,2-5', FALSE),
			array('2101-20-5', FALSE),
			array('2104.05-40', FALSE),
			array('2105-05-40', FALSE),
			array('2106-abc-5', FALSE),
			array('2107-dec-', FALSE),
			array('2108-dec-5-12:05:21', FALSE),
			array('2109-dec-5 14:05:21 P', FALSE),
			array('2110-dec-5 10:05;21', FALSE),
			array('2110-dec-5 10:0521', FALSE),
			array('2110-dec-5 10:100:50', FALSE),
			array('2110-dec-5 210:10:50', FALSE),
		);
	}
}
