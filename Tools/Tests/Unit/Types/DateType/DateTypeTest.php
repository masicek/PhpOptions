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
 * DatetimeTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\DateType::__construct
 */
class DateTypeTest extends TestCase
{


	public function testDefaultSettings()
	{
		$type = new DateType();

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$returnTimestamp = $this->getPropertyValue($type, 'timestamp');
		$this->assertFalse($returnTimestamp);
	}


	public function testNotUseFilter()
	{
		$type = new DateType(array('notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$returnTimestamp = $this->getPropertyValue($type, 'timestamp');
		$this->assertFalse($returnTimestamp);
	}


	public function testReturnTimestamp()
	{
		$type = new DateType(array('timestamp'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$returnTimestamp = $this->getPropertyValue($type, 'timestamp');
		$this->assertTrue($returnTimestamp);
	}


	public function testNotUseFilterAndReturnTimestamp()
	{
		$type = new DateType(array('timestamp', 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$returnTimestamp = $this->getPropertyValue($type, 'timestamp');
		$this->assertTrue($returnTimestamp);
	}


}
