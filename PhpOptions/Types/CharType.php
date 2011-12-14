<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace PhpOptions\Types;

require_once __DIR__ . '/AType.php';

/**
 * Char type
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class CharType extends AType
{


	/**
	 * Check type of value.
	 *
	 * @param mixed $value Checked value
	 *
	 * @return bool
	 */
	public function check($value)
	{
		return (bool)(strlen($value) == 1);
	}


}
