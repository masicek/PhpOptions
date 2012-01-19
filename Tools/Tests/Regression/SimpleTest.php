<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
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
 * SimpleTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class SimpleTest extends TestCase
{


	/**
	 * @dataProvider okProvider
	 */
	public function testOk($arguments, $values)
	{
		$this->setArguments($arguments);

		// define options
		$optionsList = array();
		$optionsList[] = Option::make('Help');
		$optionsList[] = Option::make('Name')->value();
		$optionsList[] = Option::make('Home')->short()->long('home-dir')->value(FALSE)->defaults('./home/common');
		$optionsList[] = Option::make('Favorite color')->value();
		$optionsList[] = Option::make('Color of eye')->value();

		$options = new Options();
		$options->add($optionsList);
		$options->defaults('Help');
		$options->description('Lotrem ipsum dolor sit amet');

		// get values
		$this->assertEquals($values[0], $options->get('Help'));
		$this->assertEquals($values[1], $options->get('Name'));
		$this->assertEquals($values[2], $options->get('Home'));
		$this->assertEquals($values[3], $options->get('-f'));
		$this->assertEquals($values[4], $options->get('--color-of-eye'));
	}


	public function okProvider()
	{
		return array(
			array('-h', array(TRUE, FALSE, './home/common', FALSE, FALSE)),
			array('--help', array(TRUE, FALSE, './home/common', FALSE, FALSE)),
			array('-n "Jan Novak"', array(FALSE, 'Jan Novak', './home/common', FALSE, FALSE)),
			array('--home-dir', array(FALSE, FALSE, './home/common', FALSE, FALSE)),
			array('--home-dir "./home/jnovak"', array(FALSE, FALSE, './home/jnovak', FALSE, FALSE)),
			array('-n "Jan Novak" --home-dir "./home/jnovak"', array(FALSE, 'Jan Novak', './home/jnovak', FALSE, FALSE)),
			array('-n "Jan Novak" -f "blue" -c "green"', array(FALSE, 'Jan Novak', './home/common', 'blue', 'green')),
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
		$optionsList[] = Option::make('Help');
		$optionsList[] = Option::make('Name')->value();
		$optionsList[] = Option::make('Home')->short()->long('home-dir')->value(FALSE)->defaults('./home/common');
		$optionsList[] = Option::make('Favorite color')->value();
		$optionsList[] = Option::make('Color of eye')->value();

		$options = new Options();

		$this->setExpectedException('\PhpOptions\UserBadCallException');
		$options->add($optionsList);
	}


	public function wrongProvider()
	{
		return array(
			array('-n'),
		);
	}


}
