<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\FileType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\FileType;

require_once ROOT . '/Types/FileType.php';

/**
 * FileTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\FileType::__construct
 */
class FileTypeTest extends TestCase
{


	public function testDefaultSettings()
	{
		$type = new FileType();

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$returnBase = $this->getPropertyValue($type, 'base');
		$this->assertNull($returnBase);
	}


	public function testNotUseFilter()
	{
		$type = new FileType(array('notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$returnBase = $this->getPropertyValue($type, 'base');
		$this->assertNull($returnBase);
	}


	public function testPrepandBase()
	{
		$type = new FileType(array('./test/prepand/path'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);

		$returnBase = $this->getPropertyValue($type, 'base');
		$this->assertEquals('./test/prepand/path', $returnBase);
	}


	public function testNotUseFilterAndPrepandBase()
	{
		$type = new FileType(array('./test/prepand/path', 'notFilter'));

		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);

		$returnBase = $this->getPropertyValue($type, 'base');
		$this->assertEquals('./test/prepand/path', $returnBase);
	}


}
