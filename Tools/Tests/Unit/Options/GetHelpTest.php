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
		$prefix = '    ';
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
		$prefix = '    ';
		$this->assertEquals(
				'Test Group' . PHP_EOL .
				$prefix . '[-f, --foo]' . PHP_EOL .
				$prefix . '[-b, --bar]' . PHP_EOL .
				PHP_EOL .
				'NON GROUP OPTIONS:' . PHP_EOL .
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
		$prefix = '    ';
		$this->assertEquals(
				'Test Group 1' . PHP_EOL .
				$prefix . '[-f, --foo]' . PHP_EOL .
				$prefix . '[-b, --bar]' . PHP_EOL .
				'Test Group 2' . PHP_EOL .
				$prefix . '[-f, --foo]' . PHP_EOL .
				$prefix . '[-c, --car]',
			trim($help));
	}


	public function testWappiningDescription()
	{
		$options = new Options();
		$options->description('Lorem ipsum dolor sit amet, consectetur adipiscing elit. ' .
			'Proin dignissim rhoncus odio et auctor. Aliquam vel velit ut mauris rutrum ' .
			'gravida pretium et nisi.'
		);

		$help = $options->getHelp(10);

		$this->assertEquals(
			'Lorem' . PHP_EOL .
			'ipsum' . PHP_EOL .
			'dolor sit' . PHP_EOL .
			'amet,' . PHP_EOL .
			'consectetu' . PHP_EOL .
			'r' . PHP_EOL .
			'adipiscing' . PHP_EOL .
			'elit.' . PHP_EOL .
			'Proin' . PHP_EOL .
			'dignissim' . PHP_EOL .
			'rhoncus' . PHP_EOL .
			'odio et' . PHP_EOL .
			'auctor.' . PHP_EOL .
			'Aliquam' . PHP_EOL .
			'vel velit' . PHP_EOL .
			'ut mauris' . PHP_EOL .
			'rutrum' . PHP_EOL .
			'gravida' . PHP_EOL .
			'pretium et' . PHP_EOL .
			'nisi.',
		trim($help));
	}


	public function testWappiningOptionsWithIndent()
	{
		$optionsList = array();
		$optionsList[] = Option::make('Foo')->description('Lorem ipsum dolor sit amet, consectetur
			adipiscing elit.')->value()->defaults('FFF');
		$optionsList[] = Option::make('Bar')->short()->description('Lorem ipsum dolor sit amet, consectetur ' .
			'adipiscing elit.')->value()->defaults('BBB');
		$optionsList[] = Option::make('Car')->description('Second lorem ipsum dolor sit amet,' . PHP_EOL .
			'consectetur adipiscing elit.');

		$options = new Options();
		$options->description('Lorem ipsum dolor sit amet.');
		$options->add($optionsList);
		$options->group('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', array('Foo', 'Bar'));
		$options->dependences('Foo', array('Bar'));

		$help = $options->getHelp(20);

		$prefix = '    ';
		$this->assertEquals(
				'Lorem ipsum dolor' . PHP_EOL .
				'sit amet.' . PHP_EOL .
				'' . PHP_EOL .
				'Lorem ipsum dolor' . PHP_EOL .
				'sit amet,' . PHP_EOL .
				'consectetur' . PHP_EOL .
				'adipiscing elit.' . PHP_EOL .
				$prefix . '[-f="VALUE",' . PHP_EOL .
				$prefix . '--foo="VALUE"]' . PHP_EOL .
				$prefix . $prefix . 'DEFAULT="FFF"' . PHP_EOL .
				$prefix . $prefix . 'NEEDED:' . PHP_EOL .
				$prefix . $prefix . '--bar' . PHP_EOL .
				$prefix . $prefix . 'Lorem ipsum' . PHP_EOL .
				$prefix . $prefix . 'dolor sit' . PHP_EOL .
				$prefix . $prefix . 'amet,' . PHP_EOL .
				$prefix . $prefix . 'consectetur' . PHP_EOL .
				$prefix . $prefix . '' . PHP_EOL .
				$prefix . $prefix . 'adipiscing' . PHP_EOL .
				$prefix . $prefix . 'elit.' . PHP_EOL .
				$prefix . '[--bar="VALUE"]' . PHP_EOL .
				$prefix . $prefix . 'DEFAULT="BBB"' . PHP_EOL .
				$prefix . $prefix . 'Lorem ipsum' . PHP_EOL .
				$prefix . $prefix . 'dolor sit' . PHP_EOL .
				$prefix . $prefix . 'amet,' . PHP_EOL .
				$prefix . $prefix . 'consectetur' . PHP_EOL .
				$prefix . $prefix . 'adipiscing' . PHP_EOL .
				$prefix . $prefix . 'elit.' . PHP_EOL .
				'' . PHP_EOL .
				'NON GROUP OPTIONS:' . PHP_EOL .
				$prefix . '[-c, --car]' . PHP_EOL .
				$prefix . $prefix . 'Second lorem' . PHP_EOL .
				$prefix . $prefix . 'ipsum dolor' . PHP_EOL .
				$prefix . $prefix . 'sit amet,' . PHP_EOL .
				$prefix . $prefix . '' . PHP_EOL .
				$prefix . $prefix . 'consectetur' . PHP_EOL .
				$prefix . $prefix . 'adipiscing' . PHP_EOL .
				$prefix . $prefix . 'elit.',
			trim($help));
	}
}
