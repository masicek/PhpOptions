<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\DirectoryType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\DirectoryType;

require_once ROOT . '/Types/DirectoryType.php';

/**
 * DirectoryTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\DirectoryType::__construct
 */
class DirectoryTypeTest extends TestCase
{


	public function testDefaultSettings()
	{
		$type = new DirectoryType();

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$base = $this->getPropertyValue($type, 'base');
		$this->assertNull($base);
	}


	public function testNotUseFilter()
	{
		$type = new DirectoryType(array('notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$base = $this->getPropertyValue($type, 'base');
		$this->assertNull($base);
	}


	public function testPrepandBase()
	{
		$type = new DirectoryType(array('./test/prepand/path'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$base = $this->getPropertyValue($type, 'base');
		$this->assertEquals('./test/prepand/path', $base);
	}


	public function testNotUseFilterAndPrepandBase()
	{
		$type = new DirectoryType(array('./test/prepand/path', 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$base = $this->getPropertyValue($type, 'base');
		$this->assertEquals('./test/prepand/path', $base);
	}


}
