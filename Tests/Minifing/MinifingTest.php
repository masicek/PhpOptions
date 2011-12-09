<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Minified;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Options;
use \PhpOptions\Option;

require_once ROOT . '/Minifing/PhpOptions.min.php';

define('IS_MINI', TRUE);

/**
 * MinifingTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class MinifingTest extends TestCase
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
		$optionsList[] = Option::make('Name')->value(FALSE);
		$optionsList[] = Option::integer('Age', 'unsigned')->value(FALSE);

		$options = new Options();
		$options->add($optionsList);
		$options->defaults('Help');

		// get values
		$this->assertEquals($values[0], $options->get('Help'));
		$this->assertEquals($values[1], $options->get('Name'));
		$this->assertEquals($values[2], $options->get('Age'));
	}


	public function okProvider()
	{
		return array(
			array('', array(TRUE, FALSE, FALSE,)),
			array('-h', array(TRUE, FALSE, FALSE)),
			array('--help', array(TRUE, FALSE, FALSE)),
			array('-n "Jan Novak"', array(FALSE, 'Jan Novak', FALSE)),
			array('-a 25', array(FALSE, FALSE, 25)),
			array('-n "Jan Novak" -a 25', array(FALSE, 'Jan Novak', 25)),
		);
	}


}
