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
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\IntegerType::check
 */
class CheckTest extends TestCase
{


	public function testSignedOk()
	{
		$type = new IntegerType();
		$this->assertTrue($type->check(123));
		$this->assertTrue($type->check(-456));
		$this->assertTrue($type->check(+789));
		$this->assertTrue($type->check('123'));
		$this->assertTrue($type->check('-456'));
		$this->assertTrue($type->check('+789'));
	}


	public function testUnsignedOk()
	{
		$type = new IntegerType(array('unsigned'));
		$this->assertTrue($type->check(123));
		$this->assertTrue($type->check(+789));
		$this->assertTrue($type->check('123'));
		$this->assertTrue($type->check('+789'));
	}


	public function testSignedBad()
	{
		$type = new IntegerType();
		$this->assertFalse($type->check('abc'));
		$this->assertFalse($type->check('a123'));
		$this->assertFalse($type->check('456b'));
		$this->assertFalse($type->check('7c89'));
		$this->assertFalse($type->check('888.22'));
		$this->assertFalse($type->check('888,22'));
		$this->assertFalse($type->check(888.22));
	}


	public function testUnsignedBad()
	{
		$type = new IntegerType(array('unsigned'));
		$this->assertFalse($type->check('abc'));
		$this->assertFalse($type->check('a123'));
		$this->assertFalse($type->check('456b'));
		$this->assertFalse($type->check('7c89'));
		$this->assertFalse($type->check('-999'));
		$this->assertFalse($type->check(-999));
		$this->assertFalse($type->check('888.22'));
		$this->assertFalse($type->check('888,22'));
		$this->assertFalse($type->check(888.22));
	}


}
