<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace PhpOptions;

/**
 * Abstract type with default functions
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
abstract class AType
{

	/**
	 * Flag of using filer on value
	 *
	 * @var bool
	 */
	protected $useFilter = TRUE;


	/**
	 * Set object
	 *
	 * @param array $setting Array of setting of object
	 */
	public function __construct(&$settings = array())
	{
		if (in_array('notFilter', $settings))
		{
			unset($settings[array_search('notFilter', $settings)]);
			$this->useFilter = FALSE;
		}

		// reset indexing
		$settings = array_values($settings);
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
		return TRUE;
	}


	/**
	 * Return uppercase name of type
	 *
	 * @return string
	 */
	public function getName()
	{
		$className = get_class($this);
		$start = strrpos($className, '\\') + 1;
		$name = substr($className, $start, -4);
		return strtoupper($name);
	}


	/**
	 * Return modified value, if flag useFiletr is set on TRUE.
	 *
	 * @param mixed $value Filtered value
	 *
	 * @return mixed
	 */
	final public function filter($value)
	{
		if ($this->useFilter)
		{
			return $this->useFilter($value);
		}
		else
		{
			return $value;
		}
	}


	/**
	 * Return modified value
	 *
	 * @param mixed $value Filtered value
	 *
	 * @return mixed
	 */
	protected function useFilter($value)
	{
		return $value;
	}


}
