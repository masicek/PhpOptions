<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\IntegerType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\IntegerType;

require_once ROOT . '/Types/IntegerType.php';

/**
 * IntegerTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\IntegerType::__construct
 */
class IntegerTypeTest extends TestCase
{


	public function testDefaultSettings()
	{
		$type = new IntegerType();

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$unsigned = $this->getPropertyValue($type, 'unsigned');
		$this->assertFalse($unsigned);
	}


	public function testNotUseFilter()
	{
		$type = new IntegerType(array('notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$unsigned = $this->getPropertyValue($type, 'unsigned');
		$this->assertFalse($unsigned);
	}


	public function testUnsigned()
	{
		$type = new IntegerType(array('unsigned'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$unsigned = $this->getPropertyValue($type, 'unsigned');
		$this->assertTrue($unsigned);
	}


	public function testNotUseFilterAndUnsigned()
	{
		$type = new IntegerType(array('unsigned', 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$unsigned = $this->getPropertyValue($type, 'unsigned');
		$this->assertTrue($unsigned);
	}


}
