<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions;

use \PhpOptions\Arguments;

require_once ROOT . '/Arguments.php';

/**
 * OptionsTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Arguments::options
 * @covers PhpOptions\Arguments::setAll
 * @covers PhpOptions\Arguments::readAll
 */
class OptionsTest extends TestCase
{


	/**
	 * @dataProvider provider
	 */
	public function test($arguments, $expectedOptions, $delimiter = ' ')
	{
		// clean cached arguments
		$this->setPropertyValue('Arguments', 'PhpOptions\Arguments::$options', NULL);

		$this->setArguments($arguments, $delimiter);
		$this->assertEquals($expectedOptions, Arguments::options(), $delimiter);
	}


	/**
	 * Provider for self::test()
	 *
	 * @return array
	 */
	public function provider()
	{
		return array(
			array('--abc="xxx"', array('abc' => 'xxx')),
			array('--abc ="xxx"', array('abc' => 'xxx')),
			array('--abc "xxx"', array('abc' => 'xxx')),
			array('-abc="xxx"', array('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')),
			array('-abc ="xxx"', array('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')),
			array('-a -bc "xxx"', array('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')),
			array('-a -bc "xxx" argument1', array('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')),
			array('-a -bc "xxx" --test', array('a' => TRUE, 'b' => TRUE, 'c' => 'xxx', 'test' => TRUE)),
			array('-a -bc "xxx" --test="yyy"', array('a' => TRUE, 'b' => TRUE, 'c' => 'xxx', 'test' => 'yyy')),
			array('-a -bc "xxx" --test ="yyy"', array('a' => TRUE, 'b' => TRUE, 'c' => 'xxx', 'test' => 'yyy')),
			array('-a -bc "xxx" --test "yyy"', array('a' => TRUE, 'b' => TRUE, 'c' => 'xxx', 'test' => 'yyy')),
			array('-a -bc "xxx" argument1 --test "yyy" argument2', array('a' => TRUE, 'b' => TRUE, 'c' => 'xxx', 'test' => 'yyy')),
		);
	}


}
