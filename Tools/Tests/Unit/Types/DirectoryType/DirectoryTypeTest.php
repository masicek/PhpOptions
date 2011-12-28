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

		$makeDir = $this->getPropertyValue($type, 'makeDir');
		$this->assertFalse($makeDir);
	}


	public function testNotUseFilter()
	{
		$type = new DirectoryType(array('notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$base = $this->getPropertyValue($type, 'base');
		$this->assertNull($base);

		$makeDir = $this->getPropertyValue($type, 'makeDir');
		$this->assertFalse($makeDir);
	}


	public function testPrepandBase()
	{
		$type = new DirectoryType(array('./test/prepand/path'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$base = $this->getPropertyValue($type, 'base');
		$this->assertEquals('./test/prepand/path', $base);

		$makeDir = $this->getPropertyValue($type, 'makeDir');
		$this->assertFalse($makeDir);
	}


	public function testNotUseFilterAndPrepandBase()
	{
		$type = new DirectoryType(array('./test/prepand/path', 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$base = $this->getPropertyValue($type, 'base');
		$this->assertEquals('./test/prepand/path', $base);

		$makeDir = $this->getPropertyValue($type, 'makeDir');
		$this->assertFalse($makeDir);
	}


	public function testMakeDir()
	{
		$type = new DirectoryType(array('makeDir'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$base = $this->getPropertyValue($type, 'base');
		$this->assertNull($base);

		$makeDir = $this->getPropertyValue($type, 'makeDir');
		$this->assertTrue($makeDir);
	}


	public function testMakeDirAndNotUseFilter()
	{
		$type = new DirectoryType(array('makeDir', 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$base = $this->getPropertyValue($type, 'base');
		$this->assertNull($base);

		$makeDir = $this->getPropertyValue($type, 'makeDir');
		$this->assertTrue($makeDir);
	}


	public function testMakeDirAndPrepandBase()
	{
		$type = new DirectoryType(array('makeDir', './test/prepand/path'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$base = $this->getPropertyValue($type, 'base');
		$this->assertEquals('./test/prepand/path', $base);

		$makeDir = $this->getPropertyValue($type, 'makeDir');
		$this->assertTrue($makeDir);
	}


	public function testMakeDirAndPrepandBaseAndNotUseFilter()
	{
		$type = new DirectoryType(array('makeDir', './test/prepand/path', 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$base = $this->getPropertyValue($type, 'base');
		$this->assertEquals('./test/prepand/path', $base);

		$makeDir = $this->getPropertyValue($type, 'makeDir');
		$this->assertTrue($makeDir);
	}


}
