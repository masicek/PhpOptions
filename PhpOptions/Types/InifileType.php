<?php

/**
 * PhpOptions
 * @link git@github.com:masicek/PhpOptions.git
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace PhpOptions;

require_once __DIR__ . '/FileType.php';

/**
 * Inifile type
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class InifileType extends FileType
{

	/**
	 * Flag for use of sections
	 *
	 * @var bool
	 */
	private $sections = TRUE;

	/**
	 * List of delimiters for explode input value into array
	 *
	 * @var string
	 */
	private $delimiters = ';|';


	/**
	 * Set object
	 * 'notSection' => read all values together and do not use sections
	 *
	 * @param array $setting Array of setting of object
	 */
	public function __construct($settings = array())
	{
		parent::__construct($settings);
		if (in_array('notSections', $settings))
		{
			$this->sections = FALSE;
		}
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
		$file = parent::useFilter($value);
		$content = parse_ini_file($file, $this->sections);
		if ($this->sections)
		{
			$content = $this->mergeParent($content);
			$contentTmp = array();
			foreach ($content as $section => $values)
			{
				$contentTmp[$section] = $this->makeSubArray($values);
			}
			$content = $contentTmp;
		}
		else
		{
			$content = $this->makeSubArray($content);
		}
		return $content;
	}


	/**
	 * If some section is childe of some another section, merge theese sesctions
	 *
	 * @param array $content Contentn of all ini file
	 *
	 * @return array
	 */
	private function mergeParent($content)
	{
		$contentTmp = array();
		foreach ($content as $section => $values)
		{
			$position = strpos($section, '<');
			if ($position !== FALSE)
			{
				$child = trim(substr($section, 0, $position - 1));
				$parent = trim(substr($section, $position + 1));

				if ($child && $parent && isset($contentTmp[$parent]))
				{
					$section = $child;
					$values = array_merge($contentTmp[$parent], $values);
				}
			}
			$contentTmp[$section] = $values;
		}

		return $contentTmp;
	}


	/**
	 * Make subarray from values type of "foo.bar1"
	 *
	 * Example:
	 * from "array('foo.bar1' => 'a', 'foo.bar2' = 'b')"
	 * make "array('foo' =>array('bar1' => 'a', 'bar1' => 'b'))"
	 *
	 * @param array $content Content of all ini file
	 *
	 * @return array
	 */
	private function makeSubArray($content)
	{
		$contentNew = array();
		foreach ($content as $key => $value)
		{
			$keysNew = explode('.', $key);
			$contentNewPointer = &$contentNew;
			foreach ($keysNew as $keyNew)
			{
				if (!isset($contentNewPointer[$keyNew]))
				{
					$contentNewPointer[$keyNew] = array();
				}
				$contentNewPointer = &$contentNewPointer[$keyNew];
			}

			// explode array
			$value = preg_replace('/[' . $this->delimiters . ']+/', $this->delimiters[0], $value);
			$value = explode($this->delimiters[0], $value);
			$contentNewPointer = (count($value) == 1) ? $value[0] : $value;
		}

		return $contentNew;
	}


}
