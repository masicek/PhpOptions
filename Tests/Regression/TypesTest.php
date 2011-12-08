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
 * TypesTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class TypesTest extends TestCase
{


	public function testOk()
	{
		$this->setArguments('
			-s "Lorem ipsum  donor"
			-c "x"
			-i "-1234"
			--iu 999
			-r "-888.222"
			--ru 777.05
			-d "2001-02-5"
			--dt "2011-dec-12 2:00PM"
			-t 3PM
			--dir "../../Types/"
			-f "../../Types/AType.php"
			-e viktor@masicek.net
			--enum bbb
			--series abc,def|ghi;jkl
			--ini-file ./foo.ini
		');

		// define options
		$optionsList = array();
		$optionsList[] = Option::make('Help');
		$optionsList[] = Option::string('String');
		$optionsList[] = Option::char('Char');
		$optionsList[] = Option::integer('Integer');
		$optionsList[] = Option::integer('Integer unsigned', 'unsigned')->short()->long('iu');
		$optionsList[] = Option::real('Real');
		$optionsList[] = Option::real('Real unsigned', 'unsigned')->short()->long('ru');
		$optionsList[] = Option::date('Date');
		$optionsList[] = Option::datetime('Datetime')->short()->long('dt');
		$optionsList[] = Option::time('Time');
		$optionsList[] = Option::directory('Directory', __DIR__)->short()->long('dir');
		$optionsList[] = Option::file('File', __DIR__);
		$optionsList[] = Option::email('Email');
		$optionsList[] = Option::enum('Enum', array('A' => 'a', 'B' => 'bbb', 'C' => 1234))->short();
		$optionsList[] = Option::series('Series')->short();
		$optionsList[] = Option::inifile('Ini file', __DIR__)->short();

		$options = new Options();
		$options->add($optionsList);

		// get values
		$this->assertEquals(FALSE, $options->get('Help'));
		$this->assertEquals('Lorem ipsum  donor', $options->get('String'));
		$this->assertEquals('x', $options->get('Char'));
		$this->assertEquals(-1234, $options->get('Integer'));
		$this->assertEquals(999, $options->get('Integer unsigned'));
		$this->assertEquals(-888.222, $options->get('Real'));
		$this->assertEquals(777.05, $options->get('Real unsigned'));
		$this->assertEquals(new \DateTime('2001-02-05'), $options->get('Date'));
		$this->assertEquals(new \DateTime('2011-12-12 14:00:00'), $options->get('Datetime'));
		$this->assertEquals('03:00:00PM', $options->get('Time'));
		$this->assertEquals($this->setDirSep(__DIR__ . '/../../Types/'), $options->get('Directory'));
		$this->assertEquals($this->setDirSep(__DIR__ . '/../../Types/AType.php'), $options->get('File'));
		$this->assertEquals('viktor@masicek.net', $options->get('Email'));
		$this->assertEquals('B', $options->get('Enum'));
		$this->assertEquals(array('abc', 'def', 'ghi', 'jkl'), $options->get('Series'));
		$this->assertEquals(array(
				'section1' => array(
					'foo' => 'Lorem ipsum',
					'db' => array(
						'host' => 'localhost',
						'login' => 'root',
					),
				),
				'section2' => array(
					'foo' => 'Test 1',
					'db' => array(
						'host' => 'localhost',
						'login' => 'root',
					),
					'bar' => 'Test 2'
				),
				'section3' => array(
					'array' => array('first', 'second', 'third'),
					'last' => '123',
				),
			),
			$options->get('Ini file')
		);
	}


	public function testOkNotFiltered()
	{
		$this->setArguments('
			-s "Lorem ipsum  donor"
			-c "x"
			-i "-1234"
			--iu 999
			-r "-888.222"
			--ru 777.05
			-d "2001-02-5"
			--dt "2011-dec-12 2:00PM"
			-t 3PM
			--dir "../../Types/"
			-f "../../Types/AType.php"
			-e viktor@masicek.net
			--enum bbb
			--series abc,def|ghi;jkl
			--ini-file ./foo.ini
		');

		// define options
		$optionsList = array();
		$optionsList[] = Option::make('Help', 'notFilter');
		$optionsList[] = Option::string('String', 'notFilter');
		$optionsList[] = Option::char('Char', 'notFilter');
		$optionsList[] = Option::integer('Integer', 'notFilter');
		$optionsList[] = Option::integer('Integer unsigned', 'unsigned', 'notFilter')->short()->long('iu');
		$optionsList[] = Option::real('Real', 'notFilter');
		$optionsList[] = Option::real('Real unsigned', 'unsigned', 'notFilter')->short()->long('ru');
		$optionsList[] = Option::date('Date', 'notFilter');
		$optionsList[] = Option::datetime('Datetime', 'notFilter')->short()->long('dt');
		$optionsList[] = Option::time('Time', 'notFilter');
		$optionsList[] = Option::directory('Directory', __DIR__, 'notFilter')->short()->long('dir');
		$optionsList[] = Option::file('File', __DIR__, 'notFilter');
		$optionsList[] = Option::email('Email', 'notFilter');
		$optionsList[] = Option::enum('Enum', array('A' => 'a', 'B' => 'bbb', 'C' => 1234), 'notFilter')->short();
		$optionsList[] = Option::series('Series', 'notFilter')->short();
		$optionsList[] = Option::inifile('Ini file', __DIR__, 'notFilter')->short();

		$options = new Options();
		$options->add($optionsList);

		// get values
		$this->assertEquals(FALSE, $options->get('Help'));
		$this->assertEquals('Lorem ipsum  donor', $options->get('String'));
		$this->assertEquals('x', $options->get('Char'));
		$this->assertEquals('-1234', $options->get('Integer'));
		$this->assertEquals('999', $options->get('Integer unsigned'));
		$this->assertEquals('-888.222', $options->get('Real'));
		$this->assertEquals('777.05', $options->get('Real unsigned'));
		$this->assertEquals('2001-02-5', $options->get('Date'));
		$this->assertEquals('2011-dec-12 2:00PM', $options->get('Datetime'));
		$this->assertEquals('3PM', $options->get('Time'));
		$this->assertEquals('../../Types/', $options->get('Directory'));
		$this->assertEquals('../../Types/AType.php', $options->get('File'));
		$this->assertEquals('viktor@masicek.net', $options->get('Email'));
		$this->assertEquals('bbb', $options->get('Enum'));
		$this->assertEquals('abc,def|ghi;jkl', $options->get('Series'));
		$this->assertEquals('./foo.ini', $options->get('Ini file'));
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
		$optionsList[] = Option::string('String');
		$optionsList[] = Option::char('Char');
		$optionsList[] = Option::integer('Integer');
		$optionsList[] = Option::integer('Integer unsigned', 'unsigned')->short()->long('iu');
		$optionsList[] = Option::real('Real');
		$optionsList[] = Option::real('Real unsigned', 'unsigned')->short()->long('ru');
		$optionsList[] = Option::date('Date');
		$optionsList[] = Option::datetime('Datetime')->short()->long('dt');
		$optionsList[] = Option::time('Time');
		$optionsList[] = Option::directory('Directory', __DIR__)->short()->long('dir');
		$optionsList[] = Option::file('File', __DIR__);
		$optionsList[] = Option::email('Email');
		$optionsList[] = Option::enum('Enum', array('A' => 'a', 'B' => 'bbb', 'C' => 1234))->short();
		$optionsList[] = Option::series('Series')->short();
		$optionsList[] = Option::inifile('Ini file', __DIR__)->short();

		$options = new Options();

		$this->setExpectedException('\PhpOptions\UserBadCallException');
		$options->add($optionsList);
	}


	public function wrongProvider()
	{
		return array(
			array('-c "xy"'),
			array('-i x2bv5'),
			array('--iu "-123"'),
			array('-r a123.9'),
			array('--ru "-777.05"'),
			array('-d "2001-100-5"'),
			array('--dt "2011-ss-12 2:00PM"'),
			array('-t Lorem'),
			array('--dir "../../TypesX/"'),
			array('-f "../Types/IType"'),
			array('-e viktormasicek.net'),
			array('--enum qqq'),
			array('--ini-file ./foo2.ini'),
		);
	}


}
