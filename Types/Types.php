<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace PhpOptions;

/**
 * Class for better work with defined types extends ITypes
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class Types
{


	/**
	 * List of registered types
	 *
	 * @var array [name] => array(
	 *		'className' => [name of class with namespace]
	 *		'classPath' => [full path of file contains class of type]
	 * )
	 */
	private $registeredTypes = array();

	/**
	 * Serialized list of default types.
	 * This value is used in minified version.
	 *
	 * @var string
	 */
	private static $serializedDeafultTypes = '';


	/**
	 * Register default types.
	 * There are all files with suffix "Type.php" in this directory.
	 * Name type is prefix: "[name of type]Type.php"
	 */
	public function __construct()
	{
		foreach ($this->getDefaultTypes() as $name => $class)
		{
			$this->register($name, $class['className'], $class['classPath']);
		}
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
	public function register($name, $className, $classPath)
	{
		$name = strtolower($name);
		$this->registeredTypes[$name]['className'] = $className;
		$this->registeredTypes[$name]['classPath'] = $classPath;
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
	public function getType($type, $settings)
	{
		if (!isset($this->registeredTypes[$type]))
		{
			throw new InvalidArgumentException($type . ': Undefined type of option.');
		}

		require_once $this->registeredTypes[$type]['classPath'];
		$className = $this->registeredTypes[$type]['className'];
		$typeClass = new $className($settings);

		if (!($typeClass instanceof \PhpOptions\AType))
		{
			throw new InvalidArgumentException($type . ': Type have to be instance of \PhpOptions\AType.');
		}

		return $typeClass;
	}


	/**
	 * Return list of all defaults types with their class name and files for including.
	 *
	 * @return array
	 */
	public function getDefaultTypes()
	{
		// minified version
		if (self::$serializedDeafultTypes)
		{
			return unserialize(self::$serializedDeafultTypes);
		}

		$types = array();
		$files = scandir(__DIR__);
		foreach ($files as $file)
		{
			if (substr($file, -8) == 'Type.php')
			{
				// remove Type.php at the end
				$nameOfType = substr($file, 0, -8);

				// remove .php at the end
				$className = '\\PhpOptions\\' . substr($file, 0, -4);
				$types[$nameOfType]['className'] = $className;
				$types[$nameOfType]['classPath'] = __DIR__ . DIRECTORY_SEPARATOR . $file;
			}
		}
		unset($types['A']);
		return $types;
	}


}
