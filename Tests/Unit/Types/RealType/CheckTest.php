<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\RealType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\RealType;

require_once ROOT . '/Types/RealType.php';

/**
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\RealType::check
 */
class CheckTest extends TestCase
{


	public function testSignedOk()
	{
		$type = new RealType();
		$this->assertTrue($type->check(123));
		$this->assertTrue($type->check(-456));
		$this->assertTrue($type->check(+789));
		$this->assertTrue($type->check(123.01));
		$this->assertTrue($type->check(-456.22));
		$this->assertTrue($type->check(+789.30));
		$this->assertTrue($type->check('123'));
		$this->assertTrue($type->check('-456'));
		$this->assertTrue($type->check('+789'));
		$this->assertTrue($type->check('123.01'));
		$this->assertTrue($type->check('-456,22'));
		$this->assertTrue($type->check('+789.30'));
	}


	public function testUnsignedOk()
	{
		$type = new RealType(array('unsigned'));
		$this->assertTrue($type->check(123));
		$this->assertTrue($type->check(+789));
		$this->assertTrue($type->check(123.01));
		$this->assertTrue($type->check(+789.30));
		$this->assertTrue($type->check('123'));
		$this->assertTrue($type->check('+789'));
		$this->assertTrue($type->check('123.01'));
		$this->assertTrue($type->check('+789,30'));
	}


	public function testSignedBad()
	{
		$type = new RealType();
		$this->assertFalse($type->check('abc'));
		$this->assertFalse($type->check('a123'));
		$this->assertFalse($type->check('456b'));
		$this->assertFalse($type->check('7c89'));
	}


	public function testUnsignedBad()
	{
		$type = new RealType(array('unsigned'));
		$this->assertFalse($type->check('abc'));
		$this->assertFalse($type->check('a123'));
		$this->assertFalse($type->check('456b'));
		$this->assertFalse($type->check('7c89'));
		$this->assertFalse($type->check('-999'));
		$this->assertFalse($type->check(-999));
	}


}
