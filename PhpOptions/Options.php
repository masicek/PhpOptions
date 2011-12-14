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

/**
 * Class for better work with PHP comand-line options
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class Options
{

	/**
	 * Version of PhpOptions
	 */
	const VERSION = '1.0.0';

	/**
	 * List of possible options
	 *
	 * @var array of Option
	 */
	private $options = array();

	/**
	 * List of value of deffined options
	 *
	 * @var array ([name of option] => [value of option])
	 */
	private $optionsValues = array();

	/**
	 * Mapping short variants to name of options
	 *
	 * @var array ([short variant] => [name of option])
	 */
	private $optionsShorts = array();

	/**
	 * Mapping long variants to name of options
	 *
	 * @var array ([long variant] => [name of option])
	 */
	private $optionsLongs = array();

	/**
	 * Default option and its value
	 *
	 * @var array ('name' => [name of option], 'value' => [value of option])
	 */
	private $defaults = NULL;

	/**
	 * Common description show in help
	 *
	 * @var string
	 */
	private $description = '';

	/**
	 * List groups with names of options that belong to groups
	 *
	 * @var array ([name of group] => array of names of options)
	 */
	private $groups = array();


	/**
	 * Control that script run from command line
	 *
	 * @throws UserBadCallException Script have to run from command line.
	 */
	public function __construct()
	{
		if (php_sapi_name() !== 'cli')
		{	// @codeCoverageIgnoreStart
			throw new UserBadCallException('Script have to run from command line.');
		}	// @codeCoverageIgnoreEnd
	}


	/**
	 * Return array of arguments in command-line.
	 *
	 * @return array
	 */
	public static function arguments()
	{
		return Arguments::arguments();
	}


	/**
	 * Add option
	 *
	 * @param array|Option $options Added options
	 *
	 * @return Options
	 */
	public function add($options = array())
	{
		if (!is_array($options))
		{
			$options = array($options);
		}

		foreach ($options as $option)
		{
			$this->addOne($option);
		}

		return $this;
	}


	/**
	 * Set default option if any options is set
	 *
	 * @param string $name Name of option
	 *
	 * @throws InvalidArgumentException Unknown option.
	 * @return Options
	 */
	public function defaults($name)
	{
		if (!isset($this->options[$name]))
		{
			throw new InvalidArgumentException($name . ': Unknown option.');
		}

		$value = $this->options[$name]->getDefaults();
		$this->defaults['name'] = $name;
		$this->defaults['value'] = $value;
		if (is_null($value))
		{
			$this->defaults['value'] = TRUE;
		}

		return $this;
	}


	/**
	 * Set text of common description in generated help
	 *
	 * @param string $description Text of common description
	 *
	 * @return Options
	 */
	public function description($description)
	{
		$this->description = $description;
		return $this;
	}


	/**
	 * Return value of option.
	 * For set option without value return TRUE.
	 * If option is not set, return FALSE.
	 *
	 * @param string $name Name of option or short or long option with prefix ('-' or '--')
	 *
	 * @throws InvalidArgumentException Unknown option
	 * @return mixed
	 */
	public function get($name)
	{
		$nameInput = $name;

		// long variant to name
		if (substr($name, 0, 2) == '--')
		{
			$long = substr($name, 2);
			$name = isset($this->optionsLongs[$long]) ? $this->optionsLongs[$long] : NULL;
		}
		// short variant to name
		elseif (substr($name, 0, 1) == '-')
		{
			$short = substr($name, 1);
			$name = isset($this->optionsShorts[$short]) ? $this->optionsShorts[$short] : NULL;
		}

		if (!isset($this->optionsValues[$name]))
		{
			throw new InvalidArgumentException($nameInput . ': Unknown option.');
		}

		// default option
		if (!is_null($this->defaults) && ($this->defaults['name'] == $name) && (count(Arguments::options()) == 0))
		{
			return $this->defaults['value'];
		}

		return $this->optionsValues[$name];
	}


	/**
	 * Define dependences of options.
	 *
	 * @param string $main Main option for which we define needed options
	 * @param string|array $needed Needed options for main option
	 *
	 * @throws InvalidArgumentException Unknown option
	 * @throws UserBadCallException Some option need some another option
	 * @return Options
	 */
	public function dependences($main, $needed)
	{
		if (!is_array($needed))
		{
			$needed = array($needed);
		}

		if (!isset($this->optionsValues[$main]))
		{
			throw new InvalidArgumentException($main . ': Unknown option.');
		}

		$neededOptions = array();
		foreach ($needed as $name)
		{
			if (!isset($this->optionsValues[$name]))
			{
				throw new InvalidArgumentException($name . ': Unknown option.');
			}
			$neededOptions[] = $this->options[$name];
		}

		// if main option is defined, check needed options
		if ($this->get($main) !== FALSE)
		{
			foreach ($needed as $name)
			{
				if ($this->get($name) === FALSE)
				{
					$mainOptions = $this->options[$main]->getOptions();
					$nameOptions = $this->options[$name]->getOptions();
					throw new UserBadCallException('Option "' . $mainOptions . '" needs option "'. $nameOptions . '".');
				}
			}
		}

		$this->options[$main]->dependences($neededOptions);

		return $this;
	}


	/**
	 * Define groups of options
	 *
	 * @param string $name Name of group
	 * @param string|array $options List of options names
	 *
	 * @return Options
	 */
	public function group($name, $options)
	{
		if (in_array($name, array_keys($this->groups)))
		{
			throw new LogicException($name . ': Group already exists.');
		}

		if (!is_array($options))
		{
			$options = array($options);
		}

		foreach ($options as $optionName)
		{
			if (!isset($this->options[$optionName]))
			{
				throw new LogicException($optionName . ': Option does not exist.');
			}
		}

		$this->groups[$name] = $options;

		return $this;
	}


	/**
	 * Return "help" made from descriptions of options
	 *
	 * @return string
	 */
	public function getHelp()
	{
		$help = $this->description . "\n\n";

		$options = $this->options;

		$indent = 0;
		if ($this->groups)
		{
			foreach ($this->groups as $groupName => $optionsNames)
			{
				$help .= $groupName . "\n";
				foreach ($optionsNames as $optionName)
				{
					$help .= $options[$optionName]->getHelp(1) . "\n";
					unset($options[$optionName]);
				}
			}

			if (count($options) > 0)
			{
				$help .= "\nNON GROUP OPTIONS:\n";
			}
			$indent = 1;
		}

		// print non group options
		foreach ($options as $option)
		{
			$help .= $option->getHelp($indent) . "\n";
		}

		return $help;
	}


	// ---- private ----


	/**
	 * Add one option
	 *
	 * @param Option $option Added option
	 *
	 * @return void
	 */
	private function addOne(Option $option)
	{
		$this->checkConflicts($option);
		$name = $option->getName();
		$this->options[$name] = $option;
		$this->optionsValues[$name] = $option->getValue((bool)($this->defaults['value']));
		if ($option->getShort())
		{
			$this->optionsShorts[$option->getShort()] = $name;
		}
		if ($option->getLong())
		{
			$this->optionsLongs[$option->getLong()] = $name;
		}
	}


	/**
	 * Check conflict between added option and input option
	 *
	 * @param Option $option Checked option
	 *
	 * @throws LogicException Option already exist.
	 * @throws LogicException Option with set short variant already exist.
	 * @throws LogicException Option with set long variant already exist.
	 * @return void
	 */
	private function checkConflicts(Option $option)
	{
		$name = $option->getName();
		if (isset($this->options[$name]))
		{
			throw new LogicException($name . ': Option already exists.');
		}

		$short = $option->getShort();
		if (in_array($short, array_keys($this->optionsShorts)))
		{
			throw new LogicException($name . ': Option with short variant "' . $short . '" already exists.');
		}

		$long = $option->getLong();
		if (in_array($long, array_keys($this->optionsLongs)))
		{
			throw new LogicException($name . ': Option with long variant "' . $long . '" already exists.');
		}
	}


}
