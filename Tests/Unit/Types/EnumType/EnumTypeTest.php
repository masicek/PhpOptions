<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\EnumType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\EnumType;

require_once ROOT . '/Types/EnumType.php';

/**
 * EnumTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\EnumType::__construct
 */
class EnumTypeTest extends TestCase
{


	public function testDefaultSettings()
	{
		$type = new EnumType();

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$values = $this->getPropertyValue($type, 'values');
		$this->assertEquals(array(), $values);
	}


	public function testNotUseFilter()
	{
		$type = new EnumType(array('notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$values = $this->getPropertyValue($type, 'values');
		$this->assertEquals(array(), $values);
	}


	public function testValuesByArray()
	{
		$type = new EnumType(array(array('first', 'second')));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$values = $this->getPropertyValue($type, 'values');
		$this->assertEquals(array('first', 'second'), $values);
	}


	public function testValuesByArrayWithKeys()
	{
		$type = new EnumType(array(array('a' => 'first', 'b' => 'second')));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$values = $this->getPropertyValue($type, 'values');
		$this->assertEquals(array('a' => 'first', 'b' => 'second'), $values);
	}


	public function testValuesByArrayNotUseFilter()
	{
		$type = new EnumType(array(array('first', 'second'), 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$values = $this->getPropertyValue($type, 'values');
		$this->assertEquals(array('first', 'second'), $values);
	}


	public function testValuesByString()
	{
		$type = new EnumType(array('first second|third,fourth;fifth'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$values = $this->getPropertyValue($type, 'values');
		$this->assertEquals(array('first', 'second', 'third', 'fourth', 'fifth'), $values);
	}


	public function testValuesByStringNotUseFilter()
	{
		$type = new EnumType(array('notFilter', 'first second|third,fourth;fifth'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$values = $this->getPropertyValue($type, 'values');
		$this->assertEquals(array('first', 'second', 'third', 'fourth', 'fifth'), $values);
	}


}
