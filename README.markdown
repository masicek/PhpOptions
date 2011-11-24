PhpOptions
==========

This is class for better work with PHP comand-line options.
You can:

* define __short__ and/or __long__ variant in comman-line
* define __requirements__ of option
* define type of __value requirements__ of option
* define __default value__ of option
* define __description__ of option
* define __default option__
* generate __help__
* define __common help description__
* define __dependences__ between options

For a better understanding see the [exmaples scrips](./PhpOptions/tree/master/examples/).

Possible Exceptions:

* __InvalidArgumentException__ - exceptions made by programmer by wrong calling method (in correct scrit shoul not occured)
* __LogicException__ - exceptions made by programmer by wrong set of expected options together (in correct scrit shoul not occured)
* __UserBadCallException__ - exceptions made by user wrong using of script
