<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\InifileType;

use \Tests\PhpOptions\TestCase;
use \PhpOptions\Types\InifileType;

require_once ROOT . '/Types/InifileType.php';

/**
 * UseFilterTest
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 *
 * @covers PhpOptions\Types\InifileType::useFilter
 * @covers PhpOptions\Types\InifileType::mergeParent
 * @covers PhpOptions\Types\InifileType::makeSubArray
 */
class UseFilterTest extends TestCase
{


	public function testUseSections()
	{
		$type = new InifileType();
		$this->assertEquals(
			array(
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
			$type->filter(__DIR__ . '/foo.ini')
		);
	}


	public function testNotUseSections()
	{
		$type = new InifileType(array('notSections'));
		$this->assertEquals(
			array(
				'foo' => 'Test 1',
				'db' => array(
					'host' => 'localhost',
					'login' => 'root',
				),
				'bar' => 'Test 2',
				'array' => array('first', 'second', 'third'),
				'last' => '123'
			),
			$type->filter(__DIR__ . '/foo.ini')
		);
	}


}
