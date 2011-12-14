<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\RealType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\RealType;

require_once ROOT . '/Types/RealType.php';

/**
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\RealType::useFilter
 */
class UseFilterTest extends TestCase
{


	/**
	 * @dataProvider provider
	 */
	public function test($value, $expectedFilteredValue)
	{
		$type = new RealType();
		$filteredValue = $type->filter($value);
		$this->assertInternalType('float', $filteredValue);
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
			array('123.01', 123.01),
			array('+456,22', 456.22),
			array('-789.30', -789.3),
			array(-111, -111),
			array(+222, 222),
			array(333, 333),
			array(123.01, 123.01),
			array(+456.22, 456.22),
			array(-789.30, -789.3),
		);
	}


}
