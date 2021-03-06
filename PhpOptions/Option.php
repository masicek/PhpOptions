<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace PhpOptions;

require_once __DIR__ . '/Exceptions.php';
require_once __DIR__ . '/Arguments.php';
require_once __DIR__ . '/Types/Types.php';

/**
 * Class for bettwer work with one PHP comman-line option
 *
 * @author Viktor Mašíček <viktor@masicek.net>
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
	 * Length of indent in printed help
	 */
	const HELP_INDENT_LENGTH = 4;


	/**
	 * Object for making types objects
	 *
	 * @var Types
	 */
	private static $types = NULL;

	/**
	 * Name of option
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Type of expected value
	 *
	 * @var AType
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
	private $defaults = NULL;

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
	 * Array of needed options by this option
	 *
	 * @var array of Option
	 */
	private $needed = array();


	// ---- MAKE NEW OPTION ----


	/**
	 * Set name of option and default short and long variant in command-line
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
		$name = (isset($settings[0])) ? array_shift($settings) : '';
		$option = self::make($name);
		$option->type = self::getTypes()->getType($type, $settings);
		$option->value();
		return $option;
	}


	/**
	 * Register new type. It has to by child of abstract class AType.
	 * It is possible rewrite already registered types (so defaults too).
	 *
	 * @param string $name Name of type
	 * @param string $className Name of class of type with namespace
	 * @param string $classPath Full path of file contains class of type
	 *
	 * @return void
	 */
	public static function registerType($name, $className, $classPath)
	{
		self::getTypes()->register($name, $className, $classPath);
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
	 * @throws LogicException The default value makes sense only for options with optional value or optional option with optional or required value.
	 * @return Option
	 */
	public function defaults($defaults = NULL)
	{
		if (!is_null($defaults) && !(
			($this->valueRequired == self::VALUE_OPTIONAL) ||
			($this->valueRequired == self::VALUE_REQUIRE && $this->required == FALSE)
		))
		{
			throw new LogicException($this->name . ': The default value makes sense only for options with optional value or optional option with optional or required value.');
		}

		$this->defaults = $defaults;
		return $this;
	}


	/**
	 * Set flag of requirement of option
	 *
	 * @param bool $required
	 *
	 * @throws LogicException The required option does not make sense for option with default value and required value
	 * @return Option
	 */
	public function required($required = TRUE)
	{
		if ($this->valueRequired == self::VALUE_REQUIRE && !is_null($this->defaults))
		{
			throw new LogicException($this->name . ': The required option does not make sense for option with default value and required value.');
		}

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

		if (!is_null($this->defaults) && $value != self::VALUE_OPTIONAL)
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
	 * Set needed options by this option
	 *
	 * @param array $needed Needed options
	 *
	 * @return void
	 */
	public function dependences($needed)
	{
		$this->needed = $needed;
		return $this;
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
	public function getDefaults()
	{
		return $this->defaults;
	}


	/**
	 * Return value of option
	 * FALSE = not set
	 * TRUE = set without value
	 * other = value form command-line of default value
	 *
	 * @param bool $isDefaiultSet Flag if default option is set
	 *
	 * @return mixed
	 */
	public function getValue($isDefaultSet = FALSE)
	{
		if (is_null($this->value))
		{
			$this->value = $this->readValue($isDefaultSet);
		}

		return $this->value;
	}


	// ---- HELP ----


	/**
	 * Return short and long option in one string
	 *
	 * @param string $value Value of options (typically type of value)
	 *
	 * @return string
	 */
	public function getOptions($value = '')
	{
		$options = '';
		$options .= ($this->short ? '-' . $this->short . $value : '');
		$options .= ($this->short && $this->long ? ', ' : '');
		$options .= ($this->long ? '--' . $this->long . $value : '');
		return $options;
	}


	/**
	 * Return help for option
	 *
	 * @param integer $indent Level of indent of text
	 *
	 * @return string
	 */
	public function getHelp($maxLength, $indent = 0)
	{
		$indentString = str_repeat(' ', self::HELP_INDENT_LENGTH);

		// indent
		if ($indent)
		{
			$indent = implode('', array_fill(0, $indent, $indentString));
		}
		else
		{
			$indent = '';
		}

		// option value
		$valueType = 'VALUE';
		if ($this->type)
		{
			$valueType = $this->type->getName();
		}
		switch ($this->valueRequired)
		{
			case self::VALUE_NO:
				$value = '';
				break;
			case self::VALUE_OPTIONAL:
				$value = '[="' . $valueType . '"]';
				break;
			case self::VALUE_REQUIRE:
				$value = '="' . $valueType . '"';
				break;
		}

		// options with value
		$help = $this->getOptions($value);
		if (!$this->required)
		{
			$help = '[' . $help . ']';
		}
		$help = $this->wordwrap($help, $maxLength, $indent);


		// default value
		if (!is_null($this->defaults))
		{
			switch (gettype($this->defaults))
			{
				case 'boolean':
					$defaults = $this->defaults ? 'TRUE' : 'FALSE';
					break;
				case 'array':
					$defaults = 'array(' . implode(',', $this->defaults) . ')';
					break;
				default:
					$defaults = $this->defaults;
					break;
			}
			$help .= PHP_EOL . $this->wordwrap('DEFAULT="' . $defaults . '"', $maxLength, $indentString . $indent);
		}

		// needed options
		if (count($this->needed) > 0)
		{
			$helpNeeded = array();
			foreach ($this->needed as $neededOption)
			{
				$helpNeeded[] = $neededOption->getOptions();
			}
			$help .= PHP_EOL . $this->wordwrap('NEEDED: ' . implode('; ', $helpNeeded), $maxLength, $indentString . $indent);
		}

		// descriptions
		if ($this->description)
		{
			$help .= PHP_EOL . $this->wordwrap(str_replace(PHP_EOL, PHP_EOL . $indentString . $indent, $this->description), $maxLength, $indentString . $indent);
		}

		return $help;
	}


	// ---- PRIVATE ----


	/**
	 * Return object for work with types.
	 *
	 * @return Types\Types
	 */
	private static function getTypes()
	{
		if (!self::$types)
		{
			self::$types = new Types\Types();
		}

		return self::$types;
	}


	/**
	 * Read value of option
	 * FALSE = not set
	 * TRUE = set without value
	 * other = value form command-line of default value
	 *
	 * @param bool $isDefaiultSet Flag if default option is set
	 *
	 * @throws UserBadCallException Option has value set by short and long variant.
	 * @throws UserBadCallException Option has bad format
	 * @throws UserBadCallException Option is required.
	 * @throws UserBadCallException Option have value, but any is exected.
	 * @throws UserBadCallException Option has require value, but no set.
	 * @return mixed
	 */
	private function readValue($isDefaultSet)
	{
		$options = Arguments::options();

		$short = isset($options[$this->short]) ? $options[$this->short] : FALSE;
		$long = isset($options[$this->long]) ? $options[$this->long] : FALSE;

		// get value
		if ($short !== FALSE && $long !== FALSE)
		{
			throw new UserBadCallException($this->getOptions() . ': Option has value set by short and long variant.');
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
		if (!$isDefaultSet && $this->required && $value === FALSE)
		{
			throw new UserBadCallException($this->getOptions() . ': Option is required.');
		}

		// value required
		switch ($this->valueRequired)
		{
			case self::VALUE_NO:
				// set argument as common argument
				if (!is_bool($value))
				{
					throw new UserBadCallException($this->getOptions() . ': Option has value, but any is expected.');
				}
				break;

			case self::VALUE_OPTIONAL:
				// use default value for not set option or empty set option
				if (is_bool($value) && !is_null($this->defaults))
				{
					$value = $this->defaults;
				}
				break;

			case self::VALUE_REQUIRE:
				// option has not value
				if ($value === TRUE)
				{
					throw new UserBadCallException($this->getOptions() . ': Option has require value, but no set.');
				}
				else if ($value === FALSE && !is_null($this->defaults))
				{
					$value = $this->defaults;
				}

				break;
		}

		// check type of value + filter value
		if (($value !== FALSE) && !is_null($this->type))
		{
			if (!$this->type->check($value))
			{
				throw new UserBadCallException($this->getOptions() . ': Option has bad format.');
			}

			// do not filter optional value without set value
			if (($this->valueRequired != self::VALUE_OPTIONAL) || !is_bool($value))
			{
				$value = $this->type->filter($value);
			}
		}

		return $value;
	}


	/**
	 * Wrapping input sring on maximal length and prepand prefix on each line
	 *
	 * @param string $string Wrapped string
	 * @param int $maxLength Maximla length of one line
	 * @param string $prefix Prepanded prefix
	 *
	 * @return string
	 */
	private function wordwrap($string, $maxLength, $prefix)
	{
		$string = wordwrap($string, $maxLength - strlen($prefix), PHP_EOL, FALSE);
		$strings = explode(PHP_EOL, $string);
		array_walk($strings,
			function (&$item, $key, $prefix) {
				$item =  $prefix . trim($item);
			},
			$prefix
		);
		$string = implode(PHP_EOL, $strings);
		return $string;
	}



}
