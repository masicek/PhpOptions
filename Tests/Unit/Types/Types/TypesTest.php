<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types;

require_once ROOT . '/Types/Types.php';

/**
 * TypesTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types::__construct
 * @covers PhpOptions\Types::getDefaultTypes
 */
class TypesTest extends TestCase
{


	public function test()
	{
		$types = new Types();
		$registeredTypes = $this->getPropertyValue($types, 'registeredTypes');

		foreach ($registeredTypes as $name => $type)
		{
			$this->assertNotEmpty($name);
			$this->assertNotEmpty($type['classPath']);
			$this->assertNotEmpty($type['className']);
		}
	}


}
