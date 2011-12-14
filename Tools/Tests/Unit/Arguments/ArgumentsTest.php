<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions;

use \PhpOptions\Arguments;

require_once ROOT . '/Arguments.php';

/**
 * ArgumentsTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Arguments::arguments
 * @covers PhpOptions\Arguments::setAll
 * @covers PhpOptions\Arguments::readAll
 */
class ArgumentsTest extends TestCase
{


	/**
	 * @dataProvider provider
	 */
	public function test($arguments, $expectedOptions)
	{
		// clean cached arguments
		$this->setPropertyValue('Arguments', 'PhpOptions\Arguments::$options', NULL);

		$this->setArguments($arguments);
		$this->assertEquals($expectedOptions, Arguments::arguments());
	}


	/**
	 * Provider for self::test()
	 *
	 * @return array
	 */
	public function provider()
	{
		return array(
			array('--abc="xxx"', array()),
			array('--abc ="xxx"', array()),
			array('--abc "xxx"', array()),
			array('-abc="xxx"', array()),
			array('-abc ="xxx"', array()),
			array('-abc "xxx"', array()),
			array('-a -bc "xxx" argument1', array('argument1')),
			array('-a -bc "xxx" argument1 argument2', array('argument1', 'argument2')),
			array('-a "yyy" -bc "xxx" argument1 argument2', array('argument1', 'argument2')),
			array('-a -bc "xxx" --test', array()),
			array('-a -bc "xxx" --test="yyy"', array()),
			array('-a -bc "xxx" --test ="yyy"', array()),
			array('-a -bc "xxx" --test "yyy"', array()),
			array('-a -bc "xxx" argument1 --test "yyy" argument2', array('argument1', 'argument2')),
			array('-a -bc "xxx" argument1 --test "yyy" argument2 argument3', array('argument1', 'argument2', 'argument3')),
		);
	}


}
