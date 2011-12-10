<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions\Types\Types;

// @codeCoverageIgnoreStart
require_once ROOT . '/Types/AType.php';
// @codeCoverageIgnoreEnd

/**
 * Test type for make tests of register new own type
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class FooType extends \PhpOptions\Types\AType
{


	public function __construct($settings = array())
	{
		parent::__construct($settings);
	}


}
