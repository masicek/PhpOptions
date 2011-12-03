<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\SeriesType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\SeriesType;

require_once ROOT . '/Types/SeriesType.php';

/**
 * GetNameTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\SeriesType::getName
 */
class GetNameTest extends TestCase
{


	public function test()
	{
		$type = new SeriesType();
		$this->assertEquals('ARRAY', $type->getName());
	}


}
