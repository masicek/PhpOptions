<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\DatetimeType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\DatetimeType;

require_once ROOT . '/Types/DatetimeType.php';

/**
 * DatetimeTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\DatetimeType::__construct
 */
class DatetimeTypeTest extends TestCase
{


	public function testDefaultSettings()
	{
		$type = new DatetimeType();

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$returnTimestamp = $this->getPropertyValue($type, 'timestamp');
		$this->assertFalse($returnTimestamp);
	}


	public function testNotUseFilter()
	{
		$type = new DatetimeType(array('notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$returnTimestamp = $this->getPropertyValue($type, 'timestamp');
		$this->assertFalse($returnTimestamp);
	}


	public function testReturnTimestamp()
	{
		$type = new DatetimeType(array('timestamp'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$returnTimestamp = $this->getPropertyValue($type, 'timestamp');
		$this->assertTrue($returnTimestamp);
	}


	public function testNotUseFilterAndReturnTimestamp()
	{
		$type = new DatetimeType(array('timestamp', 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$returnTimestamp = $this->getPropertyValue($type, 'timestamp');
		$this->assertTrue($returnTimestamp);
	}


}
