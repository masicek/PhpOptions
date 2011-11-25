<?php

namespace PhpOptions;


require_once __DIR__ . '/IType.php';


/**
 * Integer type
 *
 * @link git@github.com:masicek/PhpOptions.git
 *
 * @author Viktor Masicek
 */
class IntegerType implements IType
{

	/**
	 * Flag for check signed/unsigned
	 *
	 * @var bool
	 */
	private $unsigned;


	/**
	 * Set object
	 * 'unsigned' => accept only unsigned value
	 *
	 * @param array $setting Array of setting of object
	 */
	public function __construct($settings = array())
	{
		$this->unsigned = (bool)in_array('unsigned', $settings);
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
		if ($this->unsigned)
		{
			return (bool) preg_match('/^[+]?[0-9]+$/', $value);
		}
		else
		{
			return (bool) preg_match('/^[-+]?[0-9]+$/', $value);
		}
	}


	/**
	 * Return string show in help for infrormation about type of option value
	 *
	 * @return string
	 */
	public function getHelp()
	{
		return 'integer' . ($this->unsigned ? ' unsigned' : '');
	}


}
