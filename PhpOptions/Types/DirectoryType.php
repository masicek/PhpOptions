<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace PhpOptions\Types;

require_once __DIR__ . '/AType.php';

/**
 * Directory type
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class DirectoryType extends AType
{

	/**
	 * Base path for check input path
	 *
	 * @var string
	 */
	private $base = NULL;


	/**
	 * Flag for making directory if it is not exist
	 *
	 * @var string
	 */
	private $makeDir = FALSE;


	/**
	 * Set object
	 * 'base' => base path of input value
	 *
	 * @param array $setting Array of setting of object
	 */
	public function __construct($settings = array())
	{
		parent::__construct($settings);

		if ($this->settingsHasFlag('makeDir', $settings))
		{
			$this->makeDir = TRUE;
		}

		if (isset($settings[0]))
		{
			$this->base = $settings[0];
		}
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
		$isDir = FALSE;
		if (is_dir($value))
		{
			$isDir = TRUE;
		}
		elseif ($this->base && is_dir($this->make($this->base, $value)))
		{
			$isDir = TRUE;
		}

		if (!$isDir && $this->makeDir)
		{
			$value = $this->useFilter($value);
			if ($this->isFullPath($value))
			{
				$isDir = mkdir($value, 0700, TRUE);
			}
		}

		return $isDir;
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
		// base is set and value not full path
		if ($this->base && !$this->isFullPath($value))
		{
			$value = $this->make($this->base, $value);
		}
		$value = $this->make($value , '/');

		return $value;
	}


	/**
	 * Detect if the path is full path
	 *
	 * @param string $path Detected path
	 *
	 * @return bool
	 */
	private function isFullPath($path)
	{
		return (bool)preg_match('/^([a-zA-Z]:\\\|\/)/', $path);
	}


	/**
	 * Make path from list of arguments.
	 *
	 * @return string
	 */
	private function make()
	{
		$pathParts = func_get_args();

		$ds = DIRECTORY_SEPARATOR;
		$path = implode($ds, $pathParts);

		// correct separator
		$path = str_replace('/', $ds, $path);
		$path = str_replace('\\', $ds, $path);

		// replace "/./" and "//"
		while (strpos($path, $ds . '.' . $ds) !== FALSE || strpos($path, $ds . $ds) !== FALSE)
		{
			$path = str_replace($ds . $ds, $ds, $path);
			$path = str_replace($ds . '.' . $ds, $ds, $path);
		}

		return $path;
	}


}
