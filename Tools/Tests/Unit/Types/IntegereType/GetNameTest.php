<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\IntegerType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\IntegerType;

require_once ROOT . '/Types/IntegerType.php';

/**
 * GetNameTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\IntegerType::getName
 */
class GetNameTest extends TestCase
{


	public function testSigned()
	{
		$type = new IntegerType();
		$this->assertEquals('INTEGER', $type->getName());
	}


	public function testUnsigned()
	{
		$type = new IntegerType(array('unsigned'));
		$this->assertEquals('INTEGER UNSIGNED', $type->getName());
	}


}
