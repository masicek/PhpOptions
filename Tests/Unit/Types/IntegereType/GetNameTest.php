<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\IntegerType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\IntegerType;

require_once ROOT . '/Types/IntegerType.php';

/**
 * GetNameTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\IntegerType::getName
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
