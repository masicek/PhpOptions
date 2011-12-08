<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types;

require_once ROOT . '/Types/AType.php';

/**
 * Test type for make tests of register new own type
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class FooType extends \PhpOptions\AType
{


	public function __construct($settings = array())
	{
		parent::__construct($settings);
	}


	protected function useFilter($value)
	{
		return 'Test filtered value';
	}


}
