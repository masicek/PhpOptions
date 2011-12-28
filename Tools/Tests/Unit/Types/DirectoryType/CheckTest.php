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
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\DirectoryType::check
 * @covers PhpOptions\Types\DirectoryType::isFullPath
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
		$base = dirname(__DIR__);
		$type = new DirectoryType(array($base));
		$this->assertTrue($type->check('DirectoryType'));
	}


	public function testWithoutBaseMakeDirNotFull()
	{
		$this->assertFalse(is_dir('newDir'));
		$this->assertFalse(is_dir('newDir/newSubdir'));

		$type = new DirectoryType(array('makeDir'));
		$this->assertFalse($type->check('newDir/newSubdir'));

		$this->assertFalse(is_dir('newDir'));
		$this->assertFalse(is_dir('newDir/newSubdir'));
	}


	public function testWithoutBaseMakeDir()
	{
		$this->assertFalse(is_dir(__DIR__ . '/../newDir'));
		$this->assertFalse(is_dir(__DIR__ . '/../newDir/newSubdir'));

		$type = new DirectoryType(array('makeDir'));
		$this->assertTrue($type->check(__DIR__ . '/../newDir/newSubdir'));

		$this->assertTrue(is_dir(__DIR__ . '/../newDir'));
		$this->assertTrue(is_dir(__DIR__ . '/../newDir/newSubdir'));

		rmdir(__DIR__ . '/../newDir/newSubdir');
		rmdir(__DIR__ . '/../newDir');
	}


	public function testWithBaseMakeDir()
	{
		$base = dirname(__DIR__);

		$this->assertFalse(is_dir($base . '/../newDir'));
		$this->assertFalse(is_dir($base . '/../newDir/newSubdir'));

		$type = new DirectoryType(array($base, 'makeDir'));
		$this->assertTrue($type->check('../newDir/newSubdir'));

		$this->assertTrue(is_dir($base . '/../newDir'));
		$this->assertTrue(is_dir($base . '/../newDir/newSubdir'));

		rmdir($base . '/../newDir/newSubdir');
		rmdir($base . '/../newDir');
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
