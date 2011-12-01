<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\AType;

use \Tests\PhpOptions\TestCase;

require_once 'FooType.php';

/**
 * ATypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\AType::__construct
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
