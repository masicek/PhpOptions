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
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\DateType::check
 * @covers PhpOptions\Types\DateType::getDatetimeString
 * @covers PhpOptions\Types\DateType::complete
 */
class CheckTest extends TestCase
{


	/**
	 * @dataProvider provider
	 */
	public function test($value, $exceptOk)
	{
		$type = new DateType();
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
			array('2003.2.5', TRUE),
			array('2006.dec.5', TRUE),
			array('2007.dec.5', TRUE),
			array('2010-06.5', TRUE),
			array('aaa', FALSE),
			array('210', FALSE),
			array('2100,2-5', FALSE),
			array('2101-20-5', FALSE),
			array('2104.05-40', FALSE),
			array('2105-05-40', FALSE),
			array('2106-abc-5', FALSE),
			array('2107-dec-', FALSE),
			array('2108-dec-5 12:05:21', FALSE),
		);
	}


}
