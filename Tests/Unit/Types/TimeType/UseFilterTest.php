<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\TimeType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\TimeType;

require_once ROOT . '/Types/TimeType.php';

/**
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\TimeType::useFilter
 */
class UseFilterTest extends TestCase
{


	public function test()
	{
		$type = new TimeType();
		$this->assertEquals('02:50:10', $type->filter('2-50:10'));
		$this->assertEquals('12:50:10', $type->filter('12-50:10'));
		$this->assertEquals('12:05:10', $type->filter('12-05:10'));
		$this->assertEquals('10:05:10AM', $type->filter('10-05:10   am'));
		$this->assertEquals('10:05:10PM', $type->filter('10-05:10pm'));
		$this->assertEquals('10:05:00', $type->filter('10-05'));
	}


}
