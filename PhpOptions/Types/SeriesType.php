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
 * Series/Array type
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class SeriesType extends AType
{

	/**
	 * List of delimiters for explode input value into array
	 *
	 * @var string
	 */
	private $delimiters = ', ;|';


	/**
	 * Set object
	 *
	 * @param array $setting Array of setting of object
	 */
	public function __construct($settings = array())
	{
		parent::__construct($settings);
		if (isset($settings[0]))
		{
			$this->delimiters = $settings[0];
		}
	}


	/**
	 * Return uppercase name of type
	 *
	 * @return string
	 */
	public function getName()
	{
		return 'ARRAY';
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
		if (is_array($value))
		{
			return $value;
		}

		$value = preg_replace('/[' . $this->delimiters . ']+/', $this->delimiters[0], $value);
		return explode($this->delimiters[0], $value);
	}


}
