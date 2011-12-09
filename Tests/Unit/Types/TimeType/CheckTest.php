<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\TimeType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\TimeType;

require_once ROOT . '/Types/TimeType.php';

/**
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\TimeType::check
 * @covers PhpOptions\TimeType::getTimeString
 * @covers PhpOptions\TimeType::complete
 */
class CheckTest extends TestCase
{


	/**
	 * @dataProvider provider
	 */
	public function test($value, $exceptOk)
	{
		$type = new TimeType();
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
			array('12:5', TRUE),
			array('12:20:5', TRUE),
			array('12:2:50', TRUE),
			array('12:2:50 P', TRUE),
			array('10:2:50 A', TRUE),
			array('10:2:50 am', TRUE),
			array('10:02:50 PM', TRUE),
			array('2000-03-20', FALSE),
			array('2001.2-5', FALSE),
			array('2002-dec.12', FALSE),
			array('2003.2.5   12', FALSE),
			array('2004.2.5 12:5', FALSE),
			array('2005.2.5 12:20:5', FALSE),
			array('2006.dec.5 12:2:50', FALSE),
			array('2007.dec.5 12:2:50 P', FALSE),
			array('2008.dec.5 10:2:50 A', FALSE),
			array('2009.dec.5 10:2:50 am', FALSE),
			array('2010-06.5 10:02:50 PM', FALSE),
			array('aaa', FALSE),
			array('210', FALSE),
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
			array('14:05:21 Pm', FALSE),
			array('10:05;21', FALSE),
			array('10:0521', FALSE),
			array('10:100:50', FALSE),
			array('210:10:50', FALSE),
			array('01:01:70', FALSE),
		);
	}


}
