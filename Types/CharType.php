<?php

namespace PhpOptions;


require_once __DIR__ . '/IType.php';


/**
 * Char type
 *
 * @link git@github.com:masicek/PhpOptions.git
 *
 * @author Viktor Masicek
 */
class CharType implements IType
{

	/**
	 * Set object
	 *
	 * @param array $setting Array of setting of object
	 */
	public function __construct($settings = array())
	{
	}


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
