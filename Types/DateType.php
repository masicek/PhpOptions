<?php

namespace PhpOptions;


require_once __DIR__ . '/IType.php';


/**
 * Date type
 *
 * Format: YEAR(-|.)MONTH(-|.)DAY
 * YEAR = four-digit number
 * MONTH = one-digit or two-digit number or short name (three character)
 * DAY = one-digit or two-digit number
 *
 * @link git@github.com:masicek/PhpOptions.git
 *
 * @author Viktor Masicek
 */
class DateType implements IType
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
		$isDate = FALSE;

		// parse value
		$match = preg_match('/^([0-9]{4})[-.]([0-9a-zA-Z]+)[-.]([0-9]{1,2})$/', $value, $matches);
		if ($match)
		{
			// prepare date string
			$year = $matches[1];
			$month = $this->complete($matches[2]);
			$day = $this->complete($matches[3]);
			$date = $year . '-' . $month . '-' . $day . ' 00:00:00';

			// check validation
			try {
				$dateObj = new \DateTime($date);
				$isDate = ($dateObj) ? TRUE : FALSE;
			} catch (\Exception $e) {
				$isDate = FALSE;
			}
		}

		return $isDate;
	}


	/**
	 * Add zero if input value have only one character
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	private function complete($value)
	{
		if (strlen($value) == 1)
		{
			$value = '0' . $value;
		}
		return $value;
	}


	/**
	 * Return string show in help for infrormation about type of option value
	 *
	 * @return string
	 */
	public function getHelp()
	{
		return 'date';
	}


}
