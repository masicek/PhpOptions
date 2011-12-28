<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Options;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Options;
use \PhpOptions\Option;

require_once ROOT . '/Options.php';
require_once ROOT . '/Option.php';

/**
 * GetHelpTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Options::getHelp
 */
class GetHelpTest extends TestCase
{


	public function testDescription()
	{
		$options = new Options();
		$options->description('Lorem ipsum');
		$help = $options->getHelp();
		$this->assertRegExp('/Lorem ipsum/', $help);
	}


	public function testGroup()
	{
		$optionsList = array();
		$optionsList[] = Option::make('Foo');
		$optionsList[] = Option::make('Bar');
		$optionsList[] = Option::make('Car');

		$options = new Options();
		$options->add($optionsList);
		$options->group('Test Group', array('Foo', 'Bar', 'Car'));

		$help = $options->getHelp();
		$prefix = "\t";
		$this->assertRegExp('/Test Group/', $help);
		$this->assertRegExp('/' . $prefix . '\[-f/', $help);
		$this->assertRegExp('/' . $prefix . '\[-b/', $help);
		$this->assertRegExp('/' . $prefix . '\[-c/', $help);
		$this->assertNotRegExp('/NON GROUP OPTIONS/', $help);
	}


	public function testNonGroup()
	{
		$optionsList = array();
		$optionsList[] = Option::make('Foo');
		$optionsList[] = Option::make('Bar');
		$optionsList[] = Option::make('Car');

		$options = new Options();
		$options->add($optionsList);

		$help = $options->getHelp();
		$this->assertNotRegExp('/NON GROUP OPTIONS/', $help);
		$this->assertRegExp('/\[-f/', $help);
		$this->assertRegExp('/\[-b/', $help);
		$this->assertRegExp('/\[-c/', $help);
	}


	public function testGroupAndNonGroup()
	{
		$optionsList = array();
		$optionsList[] = Option::make('Foo');
		$optionsList[] = Option::make('Bar');
		$optionsList[] = Option::make('Car');

		$options = new Options();
		$options->add($optionsList);
		$options->group('Test Group', array('Foo', 'Bar'));

		$help = $options->getHelp();
		$prefix = "\t";
		$this->assertEquals(
				'Test Group' . "\n" .
				$prefix . '[-f, --foo]' . "\n" .
				$prefix . '[-b, --bar]' . "\n" .
				"\n" .
				'NON GROUP OPTIONS:' . "\n" .
				$prefix . '[-c, --car]',
			trim($help));
	}


	public function testOneOptionInMoreGroups()
	{
		$optionsList = array();
		$optionsList[] = Option::make('Foo');
		$optionsList[] = Option::make('Bar');
		$optionsList[] = Option::make('Car');

		$options = new Options();
		$options->add($optionsList);
		$options->group('Test Group 1', array('Foo', 'Bar'));
		$options->group('Test Group 2', array('Foo', 'Car'));

		$help = $options->getHelp();
		$prefix = "\t";
		$this->assertEquals(
				'Test Group 1' . "\n" .
				$prefix . '[-f, --foo]' . "\n" .
				$prefix . '[-b, --bar]' . "\n" .
				'Test Group 2' . "\n" .
				$prefix . '[-f, --foo]' . "\n" .
				$prefix . '[-c, --car]',
			trim($help));
	}


}
