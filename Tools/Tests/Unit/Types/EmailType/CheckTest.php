<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\EmailType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\EmailType;

require_once ROOT . '/Types/EmailType.php';

/**
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\EmailType::check
 */
class CheckTest extends TestCase
{


	public function testOk()
	{
		$type = new EmailType();
		$this->assertTrue($type->check('foo@bar.net'));
	}


	public function testBad()
	{
		$type = new EmailType();
		$this->assertFalse($type->check('foo'));
		$this->assertFalse($type->check('@bar.net'));
		$this->assertFalse($type->check('foo@bar'));
		$this->assertFalse($type->check('foo.net'));
		$this->assertFalse($type->check('foo@.net'));
		$this->assertFalse($type->check('foo@bar.'));
	}


}
