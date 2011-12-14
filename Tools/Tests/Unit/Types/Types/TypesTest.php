<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\Types;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\Types;

require_once ROOT . '/Types/Types.php';

/**
 * TypesTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\Types::__construct
 * @covers PhpOptions\Types\Types::getDefaultTypes
 */
class TypesTest extends TestCase
{


	public function testStandart()
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


	public function testMifiedVersion()
	{
		$typesTmp = new Types();
		$registeredTypesTmp = $this->getPropertyValue($typesTmp, 'registeredTypes');

		$this->setPropertyValue('Types', '\PhpOptions\Types\Types::$serializedDeafultTypes', serialize($registeredTypesTmp));
		$types = new Types();
		$registeredTypes = $this->getPropertyValue($types, 'registeredTypes');

		$this->assertEquals($registeredTypesTmp, $registeredTypes);
		foreach ($registeredTypes as $name => $type)
		{
			$this->assertNotEmpty($name);
			$this->assertNotEmpty($type['classPath']);
			$this->assertNotEmpty($type['className']);
		}
	}


}
