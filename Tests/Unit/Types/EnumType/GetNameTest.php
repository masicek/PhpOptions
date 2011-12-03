<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\EnumType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\EnumType;

require_once ROOT . '/Types/EnumType.php';

/**
 * GetNameTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\EnumType::getName
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
