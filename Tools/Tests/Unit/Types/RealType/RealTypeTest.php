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
 * RealTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\RealType::__construct
 */
class RealTypeTest extends TestCase
{


	public function testDefaultSettings()
	{
		$type = new RealType();

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$unsigned = $this->getPropertyValue($type, 'unsigned');
		$this->assertFalse($unsigned);
	}


	public function testNotUseFilter()
	{
		$type = new RealType(array('notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$unsigned = $this->getPropertyValue($type, 'unsigned');
		$this->assertFalse($unsigned);
	}


	public function testUnsigned()
	{
		$type = new RealType(array('unsigned'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$unsigned = $this->getPropertyValue($type, 'unsigned');
		$this->assertTrue($unsigned);
	}


	public function testNotUseFilterAndUnsigned()
	{
		$type = new RealType(array('unsigned', 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$unsigned = $this->getPropertyValue($type, 'unsigned');
		$this->assertTrue($unsigned);
	}


}
