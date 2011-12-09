<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\SeriesType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\SeriesType;

require_once ROOT . '/Types/SeriesType.php';

/**
 * SeriesTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\SeriesType::__construct
 */
class SeriesTypeTest extends TestCase
{


	public function testDefaultSettings()
	{
		$type = new SeriesType();

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$delimiters = $this->getPropertyValue($type, 'delimiters');
		$this->assertEquals(', ;|', $delimiters);
	}


	public function testNotUseFilter()
	{
		$type = new SeriesType(array('notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$delimiters = $this->getPropertyValue($type, 'delimiters');
		$this->assertEquals(', ;|', $delimiters);
	}


	public function testUnsigned()
	{
		$type = new SeriesType(array('*#'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$delimiters = $this->getPropertyValue($type, 'delimiters');
		$this->assertEquals('*#', $delimiters);
	}


	public function testNotUseFilterAndUnsigned()
	{
		$type = new SeriesType(array('*#', 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$delimiters = $this->getPropertyValue($type, 'delimiters');
		$this->assertEquals('*#', $delimiters);
	}


}
