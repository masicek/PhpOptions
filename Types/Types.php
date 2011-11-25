<?php

namespace PhpOptions;


/**
 * Class for better work with defined types extends ITypes
 *
 * @link git@github.com:masicek/PhpOptions.git
 *
 * @author Viktor Masicek
 */
class Types
{

	/**
	 * Types of options value
	 */
	const TYPE_STRING = 'string';
	const TYPE_CHAR = 'char';
	const TYPE_INTEGER = 'integer'; // unsigned
	const TYPE_REAL = 'real'; // unsigned
	const TYPE_DATE = 'date';
	const TYPE_TIME = 'time';
	const TYPE_DATETIME = 'datetime';
	const TYPE_DIRECTORY = 'directory'; // exist
	const TYPE_FILE = 'file'; // exist
	const TYPE_EMAIL = 'email';
	const TYPE_ENUM = 'enum'; // array of values


	/**
	 * List of possible types of options values
	 *
	 * @return array
	 */
	public static function possibleTypes()
	{
		return array(
			self::TYPE_STRING,
			self::TYPE_CHAR,
			self::TYPE_INTEGER,
			self::TYPE_REAL,
			self::TYPE_DATE,
			self::TYPE_TIME,
			self::TYPE_DATETIME,
			self::TYPE_DIRECTORY,
			self::TYPE_FILE,
			self::TYPE_EMAIL,
			self::TYPE_ENUM,
		);
	}


	/**
	 * Get class for specifis type of option value.
	 *
	 * @param string $type Type of option value
	 * @param array $settings List of setting specific for selected type
	 *
	 * @throws InvalidArgumentException Undefined type of option.
	 * @return IType
	 */
	public static function getType($type, $settings)
	{
		if (in_array($type, self::possibleTypes()))
		{
			$class = ucfirst($type) . 'Type';
			require_once __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';
			$class = 'PhpOptions\\' . $class;
			return new $class($settings);
		}
		else
		{
			throw new InvalidArgumentException($type . ': Undefined type of option.');
		}
	}


}
