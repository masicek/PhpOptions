<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Option;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Option;

require_once ROOT . '/Option.php';
require_once ROOT . '/Exceptions.php';

/**
 * GetOptionsTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Option::getOptions
 */
class GetOptionsTest extends TestCase
{


	public function testWithoutValue()
	{
		$this->setArguments('-f --foo');
		$option = Option::make('foo');
		$this->assertEquals('-f, --foo', $option->getOptions());
	}


	public function testWithValue()
	{
		$this->setArguments('-f --foo');
		$option = Option::make('foo');
		$this->assertEquals('-f=VALUE, --foo=VALUE', $option->getOptions('=VALUE'));
	}


}
