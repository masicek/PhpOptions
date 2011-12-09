<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\InifileType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\InifileType;

require_once ROOT . '/Types/InifileType.php';

/**
 * InifileTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\InifileType::__construct
 */
class InifileTypeTest extends TestCase
{


	public function testDefaultSettings()
	{
		$type = new InifileType();

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$sections = $this->getPropertyValue($type, 'sections');
		$this->assertTrue($sections);
	}


	public function testNotUseFilter()
	{
		$type = new InifileType(array('notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$sections = $this->getPropertyValue($type, 'sections');
		$this->assertTrue($sections);
	}


	public function testNotSections()
	{
		$type = new InifileType(array('notSections'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$sections = $this->getPropertyValue($type, 'sections');
		$this->assertFalse($sections);
	}


	public function testNotUseFilterAndNotSections()
	{
		$type = new InifileType(array('notSections', 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$sections = $this->getPropertyValue($type, 'sections');
		$this->assertFalse($sections);
	}


}
