<?php

namespace PhpOptions;


require_once __DIR__ . '/IType.php';


/**
 * Enum type
 *
 * List of possible values can be set as array
 * or sring, that will by delimited by "," or " " or ";" or "|".
 *
 * @link git@github.com:masicek/PhpOptions.git
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class EnumType implements IType
{

	/**
	 * List of possible values
	 *
	 * @var array
	 */
	private $values;

	/**
	 * Set object
	 * First setting is list of possible values.
	 * If it is not array, ther list is make from substring delimited by "," or " " or ";" or "|"
	 *
	 * @param array $setting Array of setting of object
	 */
	public function __construct($settings = array())
	{
		$values = isset($settings[0]) ? $settings[0] : array();
		if (!is_array($values))
		{
			$values = preg_replace('/[,; |]/', ',', $values);
			$values = explode(',', $values);
		}
		$this->values = $values;
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
		return in_array($value, $this->values);
	}


	/**
	 * Return string show in help for infrormation about type of option value
	 *
	 * @return string
	 */
	public function getHelp()
	{
		return '(' . implode('|', $this->values) . ')';
	}


}
