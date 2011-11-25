PhpOptions
==========

This is class for better work with PHP comand-line options.
For a better understanding see the [exmaples scrips](./PhpOptions/tree/master/examples/).

Setting
-------

* define __short__ and/or __long__ variant in comman-line
* define __requirements__ of option
* define type of __value requirements__ of option
* define __default value__ of option
* define __description__ of option
* define __default option__
* generate __help__
* define __common help description__
* define __dependences__ between options
* define __groups__ of options

Exceptions
----------

* __InvalidArgumentException__ - exceptions made by programmer by wrong calling method (in correct scrit shoul not occured)
* __LogicException__ - exceptions made by programmer by wrong set of expected options together (in correct scrit shoul not occured)
* __UserBadCallException__ - exceptions made by user wrong using of script

Types
-----

* __string__ - any value
* __char__ - one character
* __integer__ - number without decimal part, __signed__/__unsigned__ variant
* __real__ - number with decimal part, __signed__/__unsigned__ variant
* __date__ - format: <code>YEAR(-|.)MONTH(-|.)DAY</code>
* __time__ - format: <code>HOURS[(-|:)MINUTES[(-|:)SECONDS]][ HOURS_FORMAT]</code>
* __datetime__ - format: <code>YEAR(-|.)MONTH(-|.)DAY[ HOURS[(-|:)MINUTES[(-|:)SECONDS]][ HOURS_FORMAT]]</code>
* __directory__ - expect path of exist directory
* __file__ - expect path of exist file
* __email__ - check corect format of email
* __enum__ - chech if value is one of expected set options
