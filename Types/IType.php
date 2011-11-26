<?php

namespace PhpOptions;


/**
 * Inteface of IType
 *
 * @link git@github.com:masicek/PhpOptions.git
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
interface IType
{

	/**
	 * Set object
	 *
	 * @param array $setting Array of setting of object
	 */
	public function __construct($settings = array());


	/**
	 * Check type of value.
	 *
	 * @param mixed $value Checked value
	 *
	 * @return bool
	 */
	public function check($value);


	/**
	 * Return string show in help for infrormation about type of option value
	 *
	 * @return string
	 */
	public function getHelp();


}
