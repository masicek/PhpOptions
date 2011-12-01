<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions;

/**
 * Extends of PHPUnit TestCase class.
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class FirstTest extends TestCase
{


	/**
	 * Test of failing test
	 */
	public function testFail()
	{
		$this->fail('Your test successfully failed!');
	}


	/**
	 * Test of OK test
	 */
	public function testOk()
	{
		$this->assertEquals(1, 1);
	}


}
