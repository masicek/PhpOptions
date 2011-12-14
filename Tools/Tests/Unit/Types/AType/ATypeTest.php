<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\AType;

use \Tests\PhpOptions\TestCase;

require_once 'FooType.php';

/**
 * ATypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\AType::__construct
 * @covers Tests\PhpOptions\Types\AType\FooType::__construct
 */
class ATypeTest extends TestCase
{


	public function testDefaultSettings()
	{
		$type = new FooType();
		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertTrue($useFilter);
	}


	public function testNotUseFilter()
	{
		$type = new FooType(array('notFilter'));
		$useFilter = $this->getPropertyValue($type, 'useFilter');
		$this->assertFalse($useFilter);
	}


}
