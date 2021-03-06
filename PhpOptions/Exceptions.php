<?php

/**
 * PhpOptions
 * @link https://github.com/masicek/PhpOptions
 * @author Viktor Mašíček <viktor@masicek.net>
 * @license "New" BSD License
 */

namespace PhpOptions;

/**
 * List of exceptions used in PhpOptions.
 *
 * @author Viktor Mašíček <viktor@masicek.net>
 */


/**
 * Exceptions made by programmer by wrong calling method.
 * In correct scrit shoul not occured.
 */
class InvalidArgumentException extends \Exception
{
}


/**
 * Exceptions made by programmer by wrong set of expected options together.
 * In correct scrit shoul not occured.
 */
class LogicException extends \Exception
{
}


/**
 * Exceptions made by user wrong using of script.
 */
class UserBadCallException extends \Exception
{
}
