<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\EnumType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\EnumType;

require_once ROOT . '/Types/EnumType.php';

/**
 * GetNameTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\EnumType::getName
 */
class GetNameTest extends TestCase
{


	public function testVaulesByArray()
	{
		$type = new EnumType(array(array('first', 'second')));
		$this->assertEquals('(first|second)', $type->getName());
	}


	public function testValuesByString()
	{
		$type = new EnumType(array('first second'));
		$this->assertEquals('(first|second)', $type->getName());
	}


}
