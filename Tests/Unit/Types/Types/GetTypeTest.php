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
require_once ROOT . '/Exceptions.php';

/**
 * GetTypeTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types::getType
 */
class GetTypeTest extends TestCase
{


	public function testKnownType()
	{
		$type = Types::getType('string', array());
		$this->assertInstanceOf('\PhpOptions\StringType', $type);
	}


	public function testUnknownType()
	{
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		Types::getType('unknown', array());
	}


}
