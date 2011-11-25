<?php

namespace PhpOptions;


require_once __DIR__ . '/Exceptions.php';
require_once __DIR__ . '/Arguments.php';
require_once __DIR__ . '/Types/Types.php';


/**
 * Class for bettwer work with one PHP comman-line option
 *
 * @link git@github.com:masicek/PhpOptions.git
 *
 * @author Viktor Masicek <viktor@masicek.net>
 */
class Option
{

	/**
	 * Type of value requirement - no value
	 */
	const VALUE_NO = 'value_no';

	/**
	 * Type of value requirement - require value
	 */
	const VALUE_REQUIRE = 'value_require';

	/**
	 * Type of value requirement - optional value
	 */
	const VALUE_OPTIONAL = 'value_optional';




	/**
	 * Name of option
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Type of expected value
	 *
	 * @var IType
	 */
	private $type = NULL;

	/**
	 * Value of options set in command-line
	 *
	 * @var mixed
	 */
	private $value = NULL;

	/**
	 * Short variant of option in command-line
	 *
	 * @var string
	 */
	private $short;

	/**
	 * Long variant of option in command-line
	 *
	 * @var string
	 */
	private $long;

	/**
	 * Defualt value of option
	 *
	 * @var string
	 */
	private $default = NULL;

	/**
	 * Flag of requirements of option
	 *
	 * @var bool
	 */
	private $required = FALSE;

	/**
	 * Flag of requirement of option value
	 *
	 * @var string
	 */
	private $valueRequired = self::VALUE_NO;

	/**
	 * Desription used in help generated for option
	 *
	 * @var string
	 */
	private $description = '';

	/**
	 * Array of names of needed options by this option
	 *
	 * @var array
	 */
	private $needed = array();


	// ---- MAKE NEW OPTION ----


	/**
	 * Set name of optiona and default short and long variant in command-line
	 * @todo accept array as second parameere for setting all object
	 *
	 * @param string $name Name of option
	 *
	 * @throws InvalidArgumentException Name of option cannot be empty.
	 */
	public function __construct($name)
	{
		if (!$name)
		{
			throw new InvalidArgumentException('Name of option cannot be empty.');
		}

		$this->name = $name;

		$long = strtolower($name);
		$long = preg_replace('/[^a-z0-9]+/', '-', $long);
		$long = preg_replace('/-+/', '-', $long);
		$this->long($long);

		$this->short(substr($long, 0, 1));
	}


	/**
	 * Create new option
	 * @see Option::__construct
	 *
	 * @param string $name Name of option
	 *
	 * @return Option
	 */
	public static function make($name)
	{
		return new Option($name);
	}


	/**
	 * Create new option of specific type.
	 * The typed option have required value as default.
	 * @see Option::make
	 *
	 * @param string $name Name of option
	 * @param array $settings Specific settings for selected type
	 *
	 * @return Option
	 */
	public static function __callStatic($type, $settings)
	{
		if (!in_array($type, Types::possibleTypes()))
		{
			throw new UndefinedMethodException($type . ': Undefined type of option.');
		}

		$name = (isset($settings[0])) ? $settings[0] : '';
		$option = self::make($name);
		array_shift($settings);
		$option->type = Types::getType($type, $settings);
		$option->value();
		return $option;
	}


	// ---- SET OPTION ----


	/**
	 * Set short variant of option in command-line
	 *
	 * @param string $short
	 *
	 * @throws LogicException Short and long varint cannot be undefined together.
	 * @throws InvalidArgumentException Short variant have to be only one character.
	 * @return Option
	 */
	public function short($short = NULL)
	{
		if (is_null($short) && is_null($this->long))
		{
			throw new LogicException($this->name . ': Short and long varint cannot be undefined together.');
		}

		if (!is_null($short) && strlen($short) != 1)
		{
			throw new InvalidArgumentException($this->name . ': Short variant has to be only one character.');
		}

		$this->short = $short;
		return $this;
	}


	/**
	 * Set long variant of option in command-line
	 *
	 * @param string $long
	 *
	 * @throws LogicException Short and long varint cannot be undefined together.
	 * @return Option
	 */
	public function long($long = NULL)
	{
		if (is_null($long) && is_null($this->short))
		{
			throw new LogicException($this->name . ': Short and long varint cannot be undefined together.');
		}

		$this->long = $long;
		return $this;
	}


	/**
	 * Set default value of option
	 *
	 * @param mixed $default
	 *
	 * @throws LogicException The default value make sense only for options with optional value.
	 * @return Option
	 */
	public function def($default = NULL)
	{
		if (!is_null($default) && $this->valueRequired != self::VALUE_OPTIONAL)
		{
			throw new LogicException($this->name . ': The default value makes sense only for options with optional value.');
		}

		$this->default = $default;
		return $this;
	}


	/**
	 * Set flag of requirement of option
	 *
	 * @param bool $required
	 *
	 * @return Option
	 */
	public function required($required = TRUE)
	{
		$this->required = (bool)$required;
		return $this;
	}


	/**
	 * Set type of requirement of value of option
	 * TRUE = require
	 * FALSE = optional
	 *
	 * @param bool $value
	 *
	 * @throws LogicException The require/non value make sense only for option without default value.
	 * @return Option
	 */
	public function value($value = TRUE)
	{
		$value = ((bool)$value) ? self::VALUE_REQUIRE : self::VALUE_OPTIONAL;

		if (!is_null($this->default) && $value != self::VALUE_OPTIONAL)
		{
			throw new LogicException($this->name . ': The require/non value makes sense only for option without default value.');
		}

		$this->valueRequired = $value;
		return $this;
	}


	/**
	 * Set description of option used in help
	 *
	 * @param string $description
	 *
	 * @return Option
	 */
	public function description($description = '')
	{
		$this->description = $description;
		return $this;
	}


	/**
	 * Set names of needed options by this option
	 *
	 * @param array $needed Names of needed options
	 */
	public function dependences($needed)
	{
		$this->needed = $needed;
	}


	// ---- GET OPTION SETTINGS ----


	/**
	 * Return name of option
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * Return short varian of option in command-line
	 *
	 * @return string
	 */
	public function getShort()
	{
		return $this->short;
	}


	/**
	 * Return long varian of option in command-line
	 *
	 * @return string
	 */
	public function getLong()
	{
		return $this->long;
	}


	/**
	 * Return default value of option in command-line
	 *
	 * @return mixed
	 */
	public function getDef()
	{
		return $this->default;
	}


	/**
	 * Return value of option
	 * FALSE = not set
	 * TRUE = set without value
	 * other = value form command-line of default value
	 *
	 * @return mixed
	 */
	public function getValue()
	{
		if (is_null($this->value))
		{
			$this->value = $this->readValue();
		}

		return $this->value;
	}


	// ---- HELP ----


	/**
	 * Return help for option
	 *
	 * @return string
	 */
	public function getHelp()
	{
		$help = $this->name . ': ';

		$help .= ($this->short ? '-' . $this->short . ' ' : '');
		$help .= ($this->long ? '--' . $this->long . ' ' : '');

		if ($this->required)
		{
			$help .= '(*)';
		}

		switch ($this->valueRequired)
		{
			case self::VALUE_NO:
				$help .= '';
				break;
			case self::VALUE_OPTIONAL:
				$help .= '[optional]';
				break;
			case self::VALUE_REQUIRE:
				$help .= '[require]';
				break;
		}

		$help .= "\t";

		$help .= $this->description;

		if (count($this->needed) > 0)
		{
			$help .= ' (needed: ' . implode(', ', $this->needed) .')';
		}

		return $help;
	}


	// ---- private ----


	/**
	 * Read value of option
	 * FALSE = not set
	 * TRUE = set without value
	 * other = value form command-line of default value
	 *
	 * @throws UserBadCallException Option has value set by short and long variant.
	 * @throws UserBadCallException Option has bad format
	 * @throws UserBadCallException Option is required.
	 * @throws UserBadCallException Option have value, but any is exected.
	 * @throws UserBadCallException Option has require value, but no set.
	 * @return mixed
	 */
	private function readValue()
	{
		$options = Arguments::options();

		$short = isset($options[$this->short]) ? $options[$this->short] : FALSE;
		$long = isset($options[$this->long]) ? $options[$this->long] : FALSE;

		// get value
		if ($short !== FALSE && $long !== FALSE)
		{
			throw new UserBadCallException($this->name . ': Option has value set by short and long variant.');
		}
		elseif ($short === FALSE && $long === FALSE)
		{
			$value = FALSE;
		}
		elseif ($short !== FALSE)
		{
			$value = $short;
		}
		else
		{
			$value = $long;
		}

		// required
		if ($this->required && $value === FALSE)
		{
			throw new UserBadCallException($this->name . ': Option is required.');
		}

		// value required
		switch ($this->valueRequired)
		{
			case self::VALUE_NO:
				// set argument as common argument
				if (!is_bool($value))
				{
					throw new UserBadCallException($this->name . ': Option have value, but any is expected.');
				}
				break;

			case self::VALUE_OPTIONAL:
				// use default value for not set option or empty set option
				if (is_bool($value))
				{
					$value = $this->default;
				}
				break;

			case self::VALUE_REQUIRE:
				// option has not value
				if ($value === TRUE)
				{
					throw new UserBadCallException($this->name . ': Option has require value, but no set.');
				}
				break;
		}

		// type of value
		if (($value !== FALSE) && !is_null($this->type) && !$this->type->check($value))
		{
			throw new UserBadCallException($this->name . ': Option has bad format.');
		}

		return $value;
	}


}
