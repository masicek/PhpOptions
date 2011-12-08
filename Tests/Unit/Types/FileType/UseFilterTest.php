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
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\FileType::useFilter
 * @covers PhpOptions\FileType::make
 */
class UseFilterTest extends TestCase
{


	public function testWithoutBase()
	{
		$type = new FileType();
		$this->assertEquals(
			$this->setDirSep('./test/file.txt'),
			$type->filter('./test/file.txt')
		);
	}


	public function testWithBase()
	{
		$type = new FileType(array(__DIR__));

		// not full path
		$this->assertEquals(
			$this->setDirSep(__DIR__ . '/test/file.txt'),
			$type->filter('./test/file.txt')
		);
		$this->assertEquals(
			$this->setDirSep(__DIR__ . '/test/file.txt'),
			$type->filter('test/file.txt')
		);

		// fulpath
		$this->assertEquals(
			$this->setDirSep('C:/test/file.txt'),
			$type->filter('C:\\test/file.txt')
		);
		$this->assertEquals(
			$this->setDirSep('/test/file.txt'),
			$type->filter('/test/file.txt')
		);
	}


}
