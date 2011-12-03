<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\CharType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\CharType;

require_once ROOT . '/Types/CharType.php';

/**
 * CheckTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\CharType::check
 */
class CheckTest extends TestCase
{


	public function testOneChar()
	{
		$type = new CharType();
		$this->assertTrue($type->check('x'));
	}


	public function testMoreChars()
	{
		$type = new CharType();
		$this->assertFalse($type->check('abc'));
		$this->assertFalse($type->check('xy'));
	}


}