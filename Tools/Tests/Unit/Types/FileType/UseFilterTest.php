<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\FileType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\FileType;

require_once ROOT . '/Types/FileType.php';

/**
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\FileType::useFilter
 * @covers PhpOptions\Types\FileType::make
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
