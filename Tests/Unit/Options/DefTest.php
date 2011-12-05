<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Options;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Options;
use \PhpOptions\Option;

require_once ROOT . '/Options.php';
require_once ROOT . '/Option.php';
require_once ROOT . '/Exceptions.php';


/**
 * DefTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Options::def
 */
class DefTest extends TestCase
{


	public function testNonExistOption()
	{
		$options = new Options();
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$options->def('Foo');
	}


	public function testOptionWithoutDefaultValue()
	{
		$options = new Options();
		$options->add(Option::make('Foo'));
		$this->assertInstanceOf('\PhpOptions\Options', $options->def('Foo'));
		$defaultOption = $this->getPropertyValue($options, 'default');
		$this->assertEquals(array('name' => 'Foo', 'value' => TRUE), $defaultOption);
	}


	public function testOptionWithDefaultValue()
	{
		$options = new Options();
		$options->add(Option::make('Foo')->value(FALSE)->def('lorem ipsum'));
		$this->assertInstanceOf('\PhpOptions\Options', $options->def('Foo'));
		$defaultOption = $this->getPropertyValue($options, 'default');
		$this->assertEquals(array('name' => 'Foo', 'value' => 'lorem ipsum'), $defaultOption);
	}


}
