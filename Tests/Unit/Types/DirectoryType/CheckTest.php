<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\DirectoryType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\DirectoryType;

require_once ROOT . '/Types/DirectoryType.php';

/**
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\DirectoryType::check
 */
class CheckTest extends TestCase
{


	public function testWithoutBaseOk()
	{
		$type = new DirectoryType();
		$this->assertTrue($type->check(__DIR__));
	}


	public function testWithBaseOk()
	{
		$d = DIRECTORY_SEPARATOR;
		$base = dirname(__DIR__);
		$type = new DirectoryType(array($base));
		$this->assertTrue($type->check('DirectoryType'));
	}


	public function testWithoutBaseBad()
	{
		$type = new DirectoryType();
		$this->assertFalse($type->check(__DIR__ . '/Nonexist'));
	}


	public function testWithBaseBad()
	{
		$type = new DirectoryType(array(__DIR__));
		$this->assertFalse($type->check('/Nonexist'));
	}


}
