<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace PhpOptions\Tools;

define('LIBS_TOOLS', __DIR__ . DIRECTORY_SEPARATOR . 'Libs');
define('DATA_TOOLS', __DIR__ . DIRECTORY_SEPARATOR . 'Data');
define('TESTS_TOOLS', __DIR__ . DIRECTORY_SEPARATOR . 'Tests');
define('ROOT_TOOLS', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'PhpOptions');

use PhpOptionsRunner\Option;
use PhpOptionsRunner\Options;
use PhpOptionsRunner\Types\Types;

/**
 * Runner of scripts for generating minified version,
 * run tests and generating documentation
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */
class Runner
{

	/**
	 * Command-line options
	 *
	 * @var PhpOptions\Options
	 */
	private $options;

	/**
	 * Flag of including PHPUnit testes
	 *
	 * @var bool
	 */
	private static $testsIncludeDone = FALSE;


	// ---- RUNNING ----


	/**
	 * Define expected options
	 */
	public function __construct()
	{
		$this->includePhpOptions();

		// set options + help
		$optionsList = array();
		$optionsList[] = Option::make('Help')->description('Show this help');
		$optionsList[] = Option::make('All')->description('Run script parts (Minifing, Tests(unit, regression, minifing), Docs)');
		$optionsList[] = Option::make('Minifing')->description('Run script for making minified veriosn of PhpOptions');
		$optionsList[] = Option::make('Tests')->description('Run all tests');
		$optionsList[] = Option::make('Tests unit')->short()->long('tu')->description('Run unit tests');
		$optionsList[] = Option::make('Tests regression')->short()->long('tr')->description('Run regression tests');
		$optionsList[] = Option::make('Tests minifing')->short()->long('tm')->description('Run minifing tests');
		$optionsList[] = Option::make('Docs')->description('Run script for generating API documenation of PhpOptions');

		try {
			$options = new Options();
			$options->add($optionsList);
			$options->defaults('Help');
			$version = Options::VERSION;
			$options->description(
				"PhpOptions $version\nauthor: Viktor Masicek <viktor@masicek.net>\n\n" .
				"Script for generating minified version, running tests\n" .
				"and generating API documentation of PhpOptions."
			);
		} catch (\PhpOptionsRunner\UserBadCallException $e) {
			echo $e->getMessage();
		}

		$this->options = $options;
	}


	/**
	 * Run scripts by options defined in command-line
	 *
	 * @return void
	 */
	public function run()
	{
		$options = $this->options;

		// help
		if ($options->get('Help'))
		{
			fwrite(STDOUT, $options->getHelp());
			return;
		}

		$all = $options->get('All');

		// minifing
		if ($all || $options->get('Minifing'))
		{
			$this->generateMinifing();
		}

		// tests
		if ($all || $options->get('Tests'))
		{
			$this->runTestsUnit();
			$this->runTestsRegression();
			$this->runTestsMinifing();
		}
		else
		{
			if ($options->get('Tests unit'))
			{
				$this->runTestsUnit();
			}
			if ($options->get('Tests regression'))
			{
				$this->runTestsRegression();
			}
			if ($options->get('Tests minifing'))
			{
				$this->runTestsMinifing();
			}
		}

		// documentation
		if ($all || $options->get('Docs'))
		{
			$this->generateDocumentation();
		}

	}


	// ---- PARTS OF RUNNING ----


	/**
	 * Generate dodumentation
	 *
	 * @return void
	 */
	private function generateDocumentation()
	{
		$this->printHeader('Generate Documentation');

		$source = ROOT_TOOLS;
		$destination = $this->setDirSep(DATA_TOOLS . '/Docs');

		$options = array(
			'--title PhpOptions',
			'--source ' . $source,
			'--todo yes',
			'--destination ' . $destination,
		);
		$options = implode(' ', $options);

		$apigen = $this->setDirSep(LIBS_TOOLS . '/Apigen/apigen.php');
		passthru('php ' . $apigen . ' ' . $options);
	}


	/**
	 * Run unit tests
	 *
	 * @return void
	 */
	private function runTestsUnit()
	{
		$this->printHeader('Run unit tests');

		$this->testsInclude();

		// run tests
		$coverage = $this->setDirSep(DATA_TOOLS . '/Coverage');
		$tests = $this->setDirSep(TESTS_TOOLS . '/Unit');
		$this->setArguments('boot.php',
			'--coverage-html ' . $coverage . '
			' . $tests
		);
		\PHPUnit_TextUI_Command::main(FALSE);

		$this->printInfo();
	}


	/**
	 * Run regression tests
	 *
	 * @return void
	 */
	private function runTestsRegression()
	{
		$this->printHeader('Run regression tests');

		$this->testsInclude();

		// run tests
		$tests = $this->setDirSep(TESTS_TOOLS . '/Regression');
		$this->setArguments('boot.php',
			$tests
		);
		\PHPUnit_TextUI_Command::main(FALSE);

		$this->printInfo();
	}


	/**
	 * Run minifing tests
	 *
	 * @return void
	 */
	private function runTestsMinifing()
	{
		$this->printHeader('Run minigfing tests');

		$this->testsInclude();

		define('MINI', $this->copyMinifingVerion('MinifingTests'));

		// run tests
		$tests = $this->setDirSep(TESTS_TOOLS . '/Minifing');
		$this->setArguments('boot.php',
			$tests
		);
		\PHPUnit_TextUI_Command::main(FALSE);

		$this->printInfo();
	}


	/**
	 * Generate minifing version
	 *
	 * @return void
	 */
	private function generateMinifing($verbose = TRUE)
	{
		if (!$verbose)
		{
			$this->printInfo('Minifing version is generating for using in this script');
		}

		$this->printHeader('Generate minigfing version', $verbose);


		// get default types
		require_once $this->setDirSep(ROOT_TOOLS . '/Types/Types.php');
		$types = new \PhpOptions\Types\Types();
		$defaultTypes = $types->getDefaultTypes();

		// list of all files
		$files = array();
		$files[] = $this->setDirSep(ROOT_TOOLS . '/Arguments.php');
		$files[] = $this->setDirSep(ROOT_TOOLS . '/Exceptions.php');
		$files[] = $this->setDirSep(ROOT_TOOLS . '/Option.php');
		$files[] = $this->setDirSep(ROOT_TOOLS . '/Options.php');
		$files[] = $this->setDirSep(ROOT_TOOLS . '/Types/AType.php');
		$files[] = $this->setDirSep(ROOT_TOOLS . '/Types/Types.php');
		foreach ($defaultTypes as $type)
		{
			$files[] = $this->setDirSep($type['classPath']);
		}

		// generate all mini
		$content = '';
		foreach ($files as $file)
		{
			$fileContent = exec('php -w ' . $file);
			// remove all require_once
			$fileContent = preg_replace('/require_once[^;]+;/', '', $fileContent);
			$content .= $fileContent . ' ';
			$this->printInfo('Generated: ' . $file, $verbose);
		}

		// set default types
		$content = str_replace(
			'private static $serializedDeafultTypes = \'\';',
			'private static $serializedDeafultTypes = \'' . serialize($defaultTypes) . '\';',
			$content
		);
		$this->printInfo('Default types set', $verbose);

		// comment with licence atc.
		require_once $this->setDirSep(ROOT_TOOLS . '/Options.php');
		$comment = '/** PhpOptions-' . \PhpOptions\Options::VERSION . ', Minified version of PhpOptions. @link https://github.com/masicek/PhpOptions @author Viktor Mašíček <viktor@masicek.net> @license "New" BSD License */';
		$this->printInfo('Comment added', $verbose);

		// save into file
		$content = '<?php ' . $comment . ' ' . $content;
		$fileMini = fopen($this->setDirSep(ROOT_TOOLS . '/../PhpOptions.min.php'), 'w');
		fwrite($fileMini, $content);

		// make copy into Tools
		copy(
			$this->setDirSep(ROOT_TOOLS . '/../PhpOptions.min.php'),
			$this->setDirSep(DATA_TOOLS . '/Minifing/PhpOptions.min.php')
		);

		$this->printInfo('Minified file was generated');
		$this->printInfo();
	}


	// ---- HELPS FUNCTIONS ----


	/**
	 * Include PHPUnit for runnig tests.
	 * Including is done one once.
	 *
	 * @return void
	 */
	private function testsInclude()
	{
		if (!self::$testsIncludeDone)
		{
			self::$testsIncludeDone = TRUE;

			// set libs as include path
			$libs = $this->setDirSep(LIBS_TOOLS . '/PHPUnit');
			set_include_path(get_include_path() . PATH_SEPARATOR . $libs);
			require_once $this->setDirSep('PHPUnit/Autoload.php');

			// path to tested classes
			define('ROOT', ROOT_TOOLS);
			define('ROOT_MINI', $this->setDirSep(ROOT_TOOLS . '/..'));

			// include my TestCase
			require_once $this->setDirSep(TESTS_TOOLS . '/TestCase.php');
		}
	}


	/**
	 * Include PhpOptions for using in this class (self::__construct and self::run)
	 *
	 * @return void
	 */
	private function includePhpOptions()
	{
		require_once $this->copyMinifingVerion('Runner');
	}


	/**
	 * Make copy of minifing version with another namespaces (appen suffix).
	 *
	 * @return string Path of new minifing version
	 */
	private function copyMinifingVerion($suffix = '')
	{
		$minOriginal = $this->setDirSep(DATA_TOOLS . '/Minifing/PhpOptions.min.php');
		if (!is_file($minOriginal))
		{
			$this->generateMinifing(FALSE);
		}

		$minNew = $this->setDirSep(DATA_TOOLS . '/Minifing/PhpOptions' . $suffix . '.min.php');
		$min = file_get_contents($minOriginal);
		$min = str_replace('PhpOptions', 'PhpOptions' . $suffix, $min);
		$minNewHandler= fopen($minNew, 'w');
		fwrite($minNewHandler, $min);

		return $minNew;
	}


	/**
	 * Print header of one runnig script
	 *
	 * @param string $header Text of printed header
	 * @param bool $turnOff Turn of printing
	 *
	 * @return void
	 */
	private function printHeader($header, $turnOff = TRUE)
	{
		if ($turnOff)
		{
			$header = $header . ':';
			$line = str_repeat('-', strlen($header));
			$this->printInfo($header);
			$this->printInfo($line);
		}
	}


	/**
	 * Print information text
	 *
	 * @param string $info Text of printed info
	 * @param bool $turnOff Turn of printing
	 *
	 * @return void
	 */
	private function printInfo($info = '', $turnOff = TRUE)
	{
		if ($turnOff)
		{
			fwrite(STDOUT, "$info\n");
		}
	}


	/**
	 * Simulate input command-line arguments
	 *
	 * @param string $arguments List of arguments
	 *
	 * @return void
	 */
	private function setArguments($scriptName, $arguments)
	{
		$arguments = preg_replace('/(' . "\r\n|\t" . ')+/', ' ', $arguments);
		$arguments = trim($arguments);
		$argumentsNew = '';
		$inQuation = FALSE;
		for ($i = 0; $i < strlen($arguments); $i++)
		{
			$char  = $arguments[$i];
			if ($char == '"' && !$inQuation)
			{
				$inQuation = TRUE;
			}
			elseif ($char == '"' && $inQuation)
			{
				$inQuation = FALSE;
			}

			if ($char == ' ' && $inQuation)
			{
				$argumentsNew .= '###SPACE###';
			}
			elseif ($char != '"')
			{
				$argumentsNew .= $char;
			}
		}
		$arguments = $argumentsNew;
		$arguments = preg_replace('/ +/', ' ', $arguments);

		$argv = explode(' ', trim($scriptName . ' ' . $arguments));

		for ($i = 0; $i < count($argv); $i++)
		{
			$argv[$i] = str_replace('###SPACE###', ' ', $argv[$i]);
		}

		$_SERVER['argv'] = $argv;
	}



	/**
	 * Set directory separator based on OS
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	private function setDirSep($path)
	{
		return str_replace('/', DIRECTORY_SEPARATOR, $path);
	}


}
