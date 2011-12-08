<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Regressions;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Options;
use \PhpOptions\Option;

require_once ROOT . '/Options.php';
require_once ROOT . '/Option.php';
require_once ROOT . '/Exceptions.php';

/**
 * DependencesTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class DependencesTest extends TestCase
{


	/**
	 * @dataProvider okProvider
	 */
	public function testOk($arguments, $values)
	{
		$this->setArguments($arguments);

		// define options
		$optionsList = array();
		$optionsList[] = Option::make('Surname')->value();
		$optionsList[] = Option::make('First name')->value();
		$optionsList[] = Option::make('School')->short('c')->value();
		$optionsList[] = Option::make('Degree')->value();

		$options = new Options();
		$options->add($optionsList);
		$options->dependences('First name', 'Surname');
		$options->dependences('Degree', array('First name', 'School'));

		// get values
		$this->assertEquals($values[0], $options->get('Surname'));
		$this->assertEquals($values[1], $options->get('First name'));
		$this->assertEquals($values[2], $options->get('School'));
		$this->assertEquals($values[3], $options->get('Degree'));
	}


	public function okProvider()
	{
		return array(
			array('--surname="Novak"', array('Novak', FALSE, FALSE, FALSE)),
			array('--first-name="Jan" --surname="Novak"', array('Novak', 'Jan', FALSE, FALSE)),
			array('--degree="Mgr." --first-name="Jan" --surname="Novak" --school="Charles University"',
				array('Novak', 'Jan', 'Charles University', 'Mgr.')),
		);
	}


	/**
	 * @dataProvider wrongProvider
	 */
	public function testWrong($arguments)
	{
		$this->setArguments($arguments);

		// define options
		$optionsList = array();
		$optionsList[] = Option::make('Surname')->value();
		$optionsList[] = Option::make('First name')->value();
		$optionsList[] = Option::make('School')->short('c')->value();
		$optionsList[] = Option::make('Degree')->value();

		$options = new Options();

		$options->add($optionsList);
		$this->setExpectedException('\PhpOptions\UserBadCallException');
		$options->dependences('First name', 'Surname');
		$options->dependences('Degree', array('First name', 'School'));
	}


	public function wrongProvider()
	{
		return array(
			array('--first-name="Jan"'),
			array('--degree="Mgr."'),
		);
	}


}
