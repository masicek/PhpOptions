<?php

namespace PhpOptions;


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
	 * List of arguments readed form command-line.
	 *
	 * @var array ([named], [common])
	 */
	private static $cacheCmdArgs = NULL;

	/**
	 * Name of option
	 *
	 * @var string
	 */
	private $name;

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
			throw new \InvalidArgumentException('Name of option cannot be empty.');
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
			throw new \LogicException($this->name . ': Short and long varint cannot be undefined together.');
		}

		if (!is_null($short) && strlen($short) != 1)
		{
			throw new \InvalidArgumentException($this->name . ': Short variant have to be only one character.');
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
			throw new \LogicException($this->name . ': Short and long varint cannot be undefined together.');
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
			throw new \LogicException($this->name . ': The default value make sense only for options with optional value.');
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
			throw new \LogicException($this->name . ': The require/non value make sense only for option without default value.');
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

		return $help;
	}


	// ---- private ----


	/**
	 * Read value of option
	 * FALSE = not set
	 * TRUE = set without value
	 * other = value form command-line of default value
	 *
	 * @throws LogicException Option has value set by short and long variant.
	 * @throws LogicException Option is required.
	 * @throws LogicException Option has require value, but no set.
	 * @return mixed
	 */
	private function readValue()
	{
		$args = $this->getCmdArgs();
		$named = $args['named'];

		$short = isset($named[$this->short]) ? $named[$this->short] : FALSE;
		$long = isset($named[$this->long]) ? $named[$this->long] : FALSE;

		// get value
		if ($short !== FALSE && $long !== FALSE)
		{
			throw new \LogicException($name . ': Option has value set by short and long variant.');
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
			throw new \LogicException($name . ': Option is required.');
		}


		// value required
		switch ($this->valueRequired)
		{
			case self::VALUE_NO:
				// set argument as common argument
				if (!is_bool($value))
				{
					self::$cacheCmdArgs['common'][] = $value;
					$value = TRUE;
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
					throw new \LogicException($this->name . ': Option has require value, but no set.');
				}
				break;
		}

		return $value;
	}


	/**
	 * Return array of arguments in command-line.
	 * Argument are prepared for better work.
	 * <pre>
	 * --abc="xxx" => ('abc' => 'xxx')
	 * --abc ="xxx" => ('abc' => 'xxx')
	 * --abc "xxx" => ('abc' => 'xxx')
	 * -abc="xxx" => ('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')
	 * -abc "xxx" => ('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')
	 * -abc ="xxx" => ('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')
	 * -a -bc ="xxx" => ('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')
	 * </pre>
	 *
	 * @return array ([named], [common])
	 */
	private function getCmdArgs()
	{
		if (is_null(self::$cacheCmdArgs))
		{
			self::$cacheCmdArgs = $this->readCmdArgs();
		}

		return self::$cacheCmdArgs;
	}


	/**
	 * Read array of arguments in command-line.
	 * Argument are prepared for better work.
	 * <pre>
	 * --abc="xxx" => ('abc' => 'xxx')
	 * --abc ="xxx" => ('abc' => 'xxx')
	 * --abc "xxx" => ('abc' => 'xxx')
	 * -abc="xxx" => ('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')
	 * -abc "xxx" => ('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')
	 * -abc ="xxx" => ('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')
	 * -a -bc ="xxx" => ('a' => TRUE, 'b' => TRUE, 'c' => 'xxx')
	 * </pre>
	 *
	 * @return array ([named], [common])
	 */
	private function readCmdArgs()
	{
		$cmdOptions = array();
		$cmdCommonValues = array();
		$args = $_SERVER['argv'];

		// delete script name
		array_shift($args);

		if (count($args) > 0)
		{
			// clean arguments
			$argsClean = array();
			foreach ($args as $arg)
			{
				$position = strpos($arg, '=');
				if ($position === 0)
				{
					$argsClean[] = substr($arg, 1);
				}
				elseif ($position !== FALSE)
				{
					$argsClean[] = substr($arg, 0, $position);
					$argsClean[] = substr($arg, $position + 1);
				}
				else
				{
					$argsClean[] = $arg;
				}
			}
			$args = $argsClean;

			$previous = NULL;
			foreach ($args as $arg)
			{
				// long option
				if (substr($arg, 0, 2) == '--')
				{
					$option = substr($arg, 2);
					$cmdOptions[$option] = TRUE;
					$previous = $option;
				}
				// short options
				elseif (substr($arg, 0, 1) == '-')
				{
					foreach (str_split(substr($arg, 1)) as $char)
					{
						$cmdOptions[$char] = TRUE;
						$previous = $char;
					}
				}
				// value for previous option
				elseif ($previous)
				{
					$cmdOptions[$previous] = $arg;
					$previous = NULL;
				}
				// common options
				else
				{
					$cmdCommonValues[] = $arg;
				}
			}
		}

		return array('named' => $cmdOptions, 'common' => $cmdCommonValues);
	}


}
