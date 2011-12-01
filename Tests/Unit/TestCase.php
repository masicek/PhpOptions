<?php

/**
 * PhpOption
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace Tests\PhpOptions;

/**
 * Extends of PHPUnit TestCase class.
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class TestCase extends \PHPUnit_Framework_TestCase
{


	/**
	 * Simulate input command-line arguments
	 *
	 * @param string $arguments List of arguments
	 *
	 * @return void
	 */
	protected function setArguments($arguments, $delimiter = ' ')
	{
		$arguments = str_replace('"', '', $arguments);
		$argv = explode($delimiter, 'my_script.php' . $delimiter . $arguments);
		$_SERVER['argv'] = $argv;
	}


	/**
	 * Change value of protected / private property.
	 *
	 * If you want to change the value of private property, which not define the object, but a parent,
	 * you need to specify the form $property "Class::$propertyName", where Class is class, which the property defined.
	 *
	 * Example: změna mapperu u FilesRepository
	 * <pre>
	 *  $this->setPropertyValue('Arguments', 'PhpOptions\Arguments::$options', NULL);
	 * </pre>
	 *
	 * @param string|object	$object Neme of class (for static property) or instance of class
	 * @param string $property Name of property
	 * @param mixed $value New value
	 *
	 * @return void
	 */
	protected function setPropertyValue($object, $property, $value)
	{
		if (($pos = strpos($property, '::$')) !== FALSE)
		{
			$class = substr($property, 0, $pos);
			$property = substr($property, $pos + 3);
		}

		$property = $this->getAccessibleProperty(isset($class) ? $class : $object, $property);
		$property->setValue($object, $value);
	}


	/**
	 * Return value of protected / private property.
	 *
	 * If you want to read the value of private property, which not define the object, but a parent,
	 * you need to specify the form $property "Class::$propertyName", where Class is class, which the property defined.
	 *
	 * @param string|object $object Neme of class (for static property) or instance of class
	 * @param string $property Name of property
	 *
	 * @return mixed
	 */
	protected function getPropertyValue($object, $property)
	{
		if (($pos = strpos($property, '::$')) !== FALSE)
		{
			$class = substr($property, 0, $pos);
			$property = substr($property, $pos + 3);
		}

		$property = $this->getAccessibleProperty(isset($class) ? $class : $object, $property);
		return $property->getValue($object);
	}


	/**
	 * Return accessible \ReflectionProperty
	 *
	 * @param string $class Name of class
	 * @param string $name Neme of property
	 *
	 * @return \ReflectionProperty
	 */
	protected function getAccessibleProperty($class, $name)
	{
		$property = new \ReflectionProperty($class, $name);
		$property->setAccessible(TRUE);

		return $property;
	}


}


/**
 * DebugDump
 * Helpful function for debug printing of variable
 *
 * @param mix $var Variable
 */
function dd($var)
{
	var_dump($var);
}
