<?php

namespace PhpOptions;


require_once __DIR__ . '/IType.php';


/**
 * Time type
 *
 * Format: HOURS[(-|:)MINUTES[(-|:)SECONDS]][ HOURS_FORMAT]
 * HOURS = one-digit or two-digit number
 * MINUTES = one-digit or two-digit number
 * SECONDS = one-digit or two-digit number
 * HOURS_FORMAT = hour format = (AM|am|A|a|PM|pm|P|p)
 *
 * @link git@github.com:masicek/PhpOptions.git
 *
 * @author Viktor Masicek
 */
class TimeType implements IType
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
		$match = preg_match('/^([0-9]{1,2})([-:]([0-9]{1,2})([-:]([0-9]{1,2}))?)?( *(AM|am|A|a|PM|pm|P|p))?$/', $value, $matches);
		if ($match)
		{
			// prepare time string
			$hours = $this->complete(isset($matches[1]) ? $matches[1] : '');
			$minutes = $this->complete(isset($matches[3]) ? $matches[3] : '');
			$seconds = $this->complete(isset($matches[5]) ? $matches[5] : '');
			$hoursFormat = isset($matches[11]) ? $matches[11] : '';
			if (strlen($hoursFormat) == 1)
			{
				$hoursFormat = $hoursFormat . 'M';
			}
			$hoursFormat = strtoupper($hoursFormat);
			$time = $hours . ':' . $minutes . ':' . $seconds . $hoursFormat;

			// check validation
			try {
				$dateObj = new \DateTime($time);
				$isDate = ($dateObj) ? TRUE : FALSE;
			} catch (\Exception $e) {
				$isDate = FALSE;
			}
		}

		return $isDate;
	}


	/**
	 * Add zero if input value have only one character
	 * Return two zero '00' if input value have not any character
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	private function complete($value)
	{
		$length = strlen($value);
		if ($length == 1)
		{
			$value = '0' . $value;
		}
		elseif ($length == 0)
		{
			$value = '00';
		}

		return $value;
	}


}
