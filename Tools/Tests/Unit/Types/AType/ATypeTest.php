<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\AType;

use \Tests\PhpOptions\TestCase;

require_once 'FooType.php';

/**
 * ATypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\AType::__construct
 * @covers Tests\PhpOptions\Types\AType\FooType::__construct
 * @covers Tests\PhpOptions\Types\AType\FooType::settingsHasFlag
 */
class ATypeTest extends TestCase
{


	public function testDefaultSettings()
	{
		$type = new FooType();
		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);
	}


	/**
	 * @dataProvider providerNotUseFilter
	 */
	public function testNotUseFilter($setting)
	{
		$type = new FooType(array($setting));
		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);
	}


	public function providerNotUseFilter()
	{
		return array(
			array('notFilter'),
			array('notfilter'),
			array('NOTfilter'),
			array('notFIltER'),
			array('NOTFILTER'),
		);
	}

}
