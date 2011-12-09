<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Option;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Option;

require_once ROOT . '/Option.php';

/**
 * GetHelpTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Option::getHelp
 */
class GetHelpTest extends TestCase
{


	public function testShort()
	{
		$option = Option::make('Foo');
		$help = $option->getHelp();
		$this->assertRegExp('/-f/', $help);

		$option = Option::make('Bar')->short();
		$help = $option->getHelp();
		$this->assertNotRegExp('/-b[^a]/', $help);
	}


	public function testLong()
	{
		$option = Option::make('Foo');
		$help = $option->getHelp();
		$this->assertRegExp('/--foo/', $help);

		$option = Option::make('Bar')->long();
		$help = $option->getHelp();
		$this->assertNotRegExp('/--bar/', $help);
	}


	/**
	 * @dataProvider providerIndent
	 */
	public function testDefaults($indent, $prefix)
	{
		$prefix .= "\t";

		$option = Option::make('Foo')->value(FALSE)->defaults('Lorem ipsum');
		$help = $option->getHelp($indent);
		$this->assertRegExp('/' . $prefix . 'DEFAULT="Lorem ipsum"/', $help);

		$option = Option::make('Bar');
		$help = $option->getHelp($indent);
		$this->assertNotRegExp('/DEFAULT/', $help);
	}


	/**
	 * @dataProvider providerIndent
	 */
	public function testDescriptions($indent, $prefix)
	{
		$prefix .= "\t";
		$option = Option::make('Foo')->description('Description of options');
		$help = $option->getHelp($indent);
		$this->assertRegExp('/' . $prefix . 'Description of option/', $help);
	}


	/**
	 * @dataProvider providerIndent
	 */
	public function testDependences($indent, $prefix)
	{
		$prefix .= "\t";

		$foo = Option::make('Foo');
		$bar = Option::make('Bar');
		$option = Option::make('Car')->dependences(array($foo, $bar));
		$help = $option->getHelp($indent);
		$this->assertRegExp('/' . $prefix . 'NEEDED: -f, --foo; -b, --bar/', $help);

		$option = Option::make('Car');
		$help = $option->getHelp($indent);
		$this->assertNotRegExp('/NEEDED/', $help);
	}


	public function testValue()
	{
		$option = Option::make('Foo')->value();
		$help = $option->getHelp();
		$this->assertRegExp('/-f="VALUE"/', $help);
		$this->assertRegExp('/--foo="VALUE"/', $help);

		$option = Option::make('Bar')->value(FALSE);
		$help = $option->getHelp();
		$this->assertRegExp('/-b\[="VALUE"\]/', $help);
		$this->assertRegExp('/--bar\[="VALUE"\]/', $help);

		$option = Option::make('Car');
		$help = $option->getHelp();
		$this->assertNotRegExp('/="VALUE"/', $help);
		$this->assertNotRegExp('/="VALUE"/', $help);
	}


	public function testType()
	{
		$option = Option::make('Foo')->value();
		$help = $option->getHelp();
		$this->assertRegExp('/-f="VALUE"/', $help);
		$this->assertRegExp('/--foo="VALUE"/', $help);

		$option = Option::string('Bar');
		$help = $option->getHelp();
		$this->assertRegExp('/-b="STRING"/', $help);
		$this->assertRegExp('/--bar="STRING"/', $help);
	}


	/**
	 * @dataProvider providerIndent
	 */
	public function testRequired($indent, $prefix)
	{
		$option = Option::make('Foo');
		$help = $option->getHelp($indent);
		$this->assertRegExp('/' . $prefix . '\[-f[^]]*--foo.*\]/', $help);

		$option = Option::make('Bar')->required();
		$help = $option->getHelp($indent);
		$this->assertNotRegExp('/' . $prefix . '\[-b[^]]*--bar.*\]/', $help);
	}


	public function providerIndent()
	{
		return array(
			array(0, ""),
			array(1, "\t"),
			array(2, "\t\t"),
		);
	}

}
