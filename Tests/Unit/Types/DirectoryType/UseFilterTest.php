<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\DirectoryType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\DirectoryType;

require_once ROOT . '/Types/DirectoryType.php';

/**
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\DirectoryType::useFilter
 * @covers PhpOptions\DirectoryType::make
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
