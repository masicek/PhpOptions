<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\RealType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\RealType;

require_once ROOT . '/Types/RealType.php';

/**
 * GetNameTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\RealType::getName
 */
class GetNameTest extends TestCase
{


	public function testSigned()
	{
		$type = new RealType();
		$this->assertEquals('REAL', $type->getName());
	}


	public function testUnsigned()
	{
		$type = new RealType(array('unsigned'));
		$this->assertEquals('REAL UNSIGNED', $type->getName());
	}


}
