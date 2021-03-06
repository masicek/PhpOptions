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
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\DirectoryType::useFilter
 * @covers PhpOptions\Types\DirectoryType::make
 * @covers PhpOptions\Types\DirectoryType::isFullPath
 */
class UseFilterTest extends TestCase
{


	public function testWithoutBase()
	{
		$type = new DirectoryType();
		$this->assertEquals(
			$this->setDirSep('./test/directory/'),
			$type->filter('./test/directory')
		);
		$this->assertEquals(
			$this->setDirSep('./test/directory/'),
			$type->filter('./test/directory/')
		);
	}


	public function testWithBase()
	{
		$type = new DirectoryType(array(__DIR__));

		// not full path
		$this->assertEquals(
			$this->setDirSep(__DIR__ . '/test/directory/'),
			$type->filter('./test/directory')
		);
		$this->assertEquals(
			$this->setDirSep(__DIR__ . '/test/directory/'),
			$type->filter('./test/directory/')
		);
		$this->assertEquals(
			$this->setDirSep(__DIR__ . '/test/directory/'),
			$type->filter('test/directory')
		);
		$this->assertEquals(
			$this->setDirSep(__DIR__ . '/test/directory/'),
			$type->filter('test/directory/')
		);

		// fulpath
		$this->assertEquals(
			$this->setDirSep('C:/test/directory/'),
			$type->filter('C:\\test/directory')
		);
		$this->assertEquals(
			$this->setDirSep('C:/test/directory/'),
			$type->filter('C:\\test/directory/')
		);
		$this->assertEquals(
			$this->setDirSep('/test/directory/'),
			$type->filter('/test/directory')
		);
		$this->assertEquals(
			$this->setDirSep('/test/directory/'),
			$type->filter('/test/directory/')
		);
	}


}
