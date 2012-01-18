<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace PhpOptions\Types;

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
		if ($this->settingsHasFlag('notFilter', $settings))
		{
			$this->useFilter = FALSE;
		}
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


	/**
	 * Return that settings has set flag (case insensitive).
	 *
	 * @param type $flag Searched flag
	 * @param array $settings Array of setting of object
	 *
	 * @return boolean
	 */
	protected function settingsHasFlag($flag, &$settings)
	{
		$flag = strtolower($flag);
		$settingsLower = $settings;
		array_walk($settingsLower, function (&$item, $key) {
			if (is_string($item))
			{
				$item = strtolower($item);
			}
		});
		$flagIdx = array_search($flag, $settingsLower);
		if ($flagIdx !== FALSE)
		{
			$hasFlag = TRUE;
			// remove flag
			unset($settings[$flagIdx]);
			// reset indexing
			$settings = array_values($settings);
		}
		else
		{
			$hasFlag = FALSE;
		}

		return $hasFlag;
	}


}
