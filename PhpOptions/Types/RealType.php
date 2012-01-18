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
 * Real type
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class RealType extends AType
{

	/**
	 * Flag for check signed/unsigned
	 *
	 * @var bool
	 */
	private $unsigned = FALSE;


	/**
	 * Set object
	 * 'unsigned' => accept only unsigned value
	 *
	 * @param array $setting Array of setting of object
	 */
	public function __construct($settings = array())
	{
		parent::__construct($settings);
		if ($this->settingsHasFlag('unsigned', $settings))
		{
			$this->unsigned = TRUE;
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
		if ($this->unsigned)
		{
			return (bool) preg_match('/^[+]?[0-9]+([.,][0-9]+)?$/', $value);
		}
		else
		{
			return (bool) preg_match('/^[-+]?[0-9]+([.,][0-9]+)?$/', $value);
		}
	}


	/**
	 * Return uppercase name of type
	 *
	 * @return string
	 */
	public function getName()
	{
		return parent::getName() . ($this->unsigned ? ' UNSIGNED' : '');
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
		return (real)str_replace(',', '.', $value);
	}


}
