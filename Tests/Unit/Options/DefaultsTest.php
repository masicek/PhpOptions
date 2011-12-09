<?php

/**
 * PhpOptions
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
 * DefaultsTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Options::defaults
 */
class DefaultsTest extends TestCase
{


	public function testNonExistOption()
	{
		$options = new Options();
		$this->setExpectedException('\PhpOptions\InvalidArgumentException');
		$options->defaults('Foo');
	}


	public function testOptionWithoutDefaultValue()
	{
		$options = new Options();
		$options->add(Option::make('Foo'));
		$this->assertInstanceOf('\PhpOptions\Options', $options->defaults('Foo'));
		$defaultOption = $this->getPropertyValue($options, 'defaults');
		$this->assertEquals(array('name' => 'Foo', 'value' => TRUE), $defaultOption);
	}


	public function testOptionWithDefaultValue()
	{
		$options = new Options();
		$options->add(Option::make('Foo')->value(FALSE)->defaults('lorem ipsum'));
		$this->assertInstanceOf('\PhpOptions\Options', $options->defaults('Foo'));
		$defaultOption = $this->getPropertyValue($options, 'defaults');
		$this->assertEquals(array('name' => 'Foo', 'value' => 'lorem ipsum'), $defaultOption);
	}


}
