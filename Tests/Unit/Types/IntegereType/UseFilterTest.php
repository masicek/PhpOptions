<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\IntegerType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\IntegerType;

require_once ROOT . '/Types/IntegerType.php';

/**
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\IntegerType::useFilter
 */
class UseFilterTest extends TestCase
{


	/**
	 * @dataProvider provider
	 */
	public function test($value, $expectedFilteredValue)
	{
		$type = new IntegerType();
		$filteredValue = $type->filter($value);
		$this->assertInternalType('integer', $filteredValue);
		$this->assertEquals($expectedFilteredValue, $filteredValue);
	}


	/**
	 * Provider for self::test
	 */
	public function provider()
	{
		return array(
			array('123', 123),
			array('+456', 456),
			array('-789', -789),
			array(-111, -111),
			array(+222, 222),
			array(333, 333),
		);
	}


}
