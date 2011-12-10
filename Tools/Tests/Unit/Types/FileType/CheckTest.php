<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\FileType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\FileType;

require_once ROOT . '/Types/FileType.php';

/**
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\FileType::check
 */
class CheckTest extends TestCase
{


	public function testWithoutBaseOk()
	{
		$type = new FileType();
		$this->assertTrue($type->check(__FILE__));
	}


	public function testWithBaseOk()
	{
		$type = new FileType(array(__DIR__));
		$this->assertTrue($type->check(basename(__FILE__)));
	}


	public function testWithoutBaseBad()
	{
		$type = new FileType();
		$this->assertFalse($type->check(__DIR__ . '/NonexistFile.txt'));
	}


	public function testWithBaseBad()
	{
		$type = new FileType(array(__DIR__));
		$this->assertFalse($type->check('/NonexistFile.txt'));
	}


}
