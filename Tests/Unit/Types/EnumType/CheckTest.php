<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\EnumType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\EnumType;

require_once ROOT . '/Types/EnumType.php';

/**
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\EnumType::check
 */
class CheckTest extends TestCase
{


	public function testValuesByArray()
	{
		$type = new EnumType(array(array('first', 'second')));
		$this->assertTrue($type->check('first'));
		$this->assertTrue($type->check('second'));
		$this->assertFalse($type->check('any'));
	}


	public function testValuesByString()
	{
		$type = new EnumType(array('first second'));
		$this->assertTrue($type->check('first'));
		$this->assertTrue($type->check('second'));
		$this->assertFalse($type->check('any'));
	}


}
