PhpOptions
==========

This is collection of classes for better work with PHP comand-line options.
We can define options, that grouped short and long options, define default value,
have typed expected values etc. We can make group from options and define dependences
from options.

This document containing user documentation, [API Documentation](http://phpoptions.masicek.net/api/index.html)
is on [phpoptions.masicek.net/api/](http://phpoptions.masicek.net/api/index.html).

Including
---------

We can use classes in directory [PhpOptions](./PhpOptions/tree/master/PhpOptions/) and
include to main classes [Options.php](./PhpOptions/tree/master/PhpOptions/Options.php) and
[Option.php](./PhpOptions/tree/master/PhpOptions/Option.php)

```php
require_once 'PhpOptions/Options.php';
require_once 'PhpOptions/Option.php';
```

Second variant is using minifing version [PhpOptions.min.php](./PhpOptions/tree/master/PhpOptions.min.php/)
and include only this one file.

```php
require_once 'PhpOptions.min.php';
```

Make one option - untyped
-------------------------

Make one option without typed value.

```php
$option = \PhpOptions\Option::make('Foo');
```

It make new option named ```Foo``` with short option ```-f``` and long option ```--foo```.


Make one option - typed
-----------------------

Make one option is same as untyped option, but with type of value expected in commad-line.
Value are set as required for typed options and it can be redefined to optional value
(see section **Set one option**).

```php
$option = \PhpOptions\Option::[NAME_OF_TYPE]('Foo');
```

Each type check format of input value and filter value on command-line.
Filter of value can turn of by ```'notFiltered'``` option in construct.
Not filered value return value read from comman-line.

```php
$option = \PhpOptions\Option::[NAME_OF_TYPE]('Foo', 'notFilter');
```

All flags options (like ```'notFiltered'```) are checked case insensitive.


Possible values of ```[NAME_OF_TYPE]```:

* char
* date
* datetime
* directory
* email
* enum
* file
* inifile
* integer
* real
* series
* string
* time


### Char type

```php
$option = \PhpOptions\Option::char('Foo');
```

* **check** - value have to be only one character
* **filter** - _no filtering_

### Date type

```php
$option = \PhpOptions\Option::date('Foo');
```

* **check** - value have to has format ```YEAR(-|.)MONTH(-|.)DAY```

	* ```YEAR``` = four-digit number
	* ```MONTH``` = one-digit or two-digit number or short name (three character)
	* ```DAY``` = one-digit or two-digit number

* **filter** - return ```\DateTime``` set on input date from command-line

```php
$option = \PhpOptions\Option::date('Foo', 'timestamp');
```

* **check** - _same as defautl_
* **filter** - return ```timestamp``` instead of ```\DateTime```

### Datetime type

```php
$option = \PhpOptions\Option::datetime('Foo');
```

* **check** - value have to has format ```YEAR(-|.)MONTH(-|.)DAY[ HOURS[(-|:)MINUTES[(-|:)SECONDS]][ HOURS_FORMAT]]```

	* ```YEAR``` = four-digit number
	* ```MONTH``` = one-digit or two-digit number or short name (three character)
	* ```DAY``` = one-digit or two-digit number
	* ```HOURS``` = one-digit or two-digit number
	* ```MINUTES``` = one-digit or two-digit number
	* ```SECONDS``` = one-digit or two-digit number
	* ```HOURS_FORMAT``` = hour format = ```(AM|am|A|a|PM|pm|P|p)```

* **filter** - return ```\DateTime``` set on input date from command-line

```php
$option = \PhpOptions\Option::datetime('Foo', 'timestamp');
```

* **check** - _same as defautl_
* **filter** - return ```timestamp``` instead of ```\DateTime```

### Directory type

```php
$option = \PhpOptions\Option::directory('Foo');
```

* **check** - check if directory read from command-line exist
* **filter** - return read path of directory from command-line with corect OS directory separator
and added separator at the end

```php
$option = \PhpOptions\Option::directory('Foo', '[BASE_PATH_OF_DIRECTORY]');
```

* **check** - check if read directory from command-line with prefix ```[BASE_PATH_OF_DIRECTORY]``` exist
* **filter** - return read directory from command-line with prefix ```[BASE_PATH_OF_DIRECTORY]```,
with corect OS directory separator and added separator at the end

```php
$option = \PhpOptions\Option::directory('Foo', 'makeDir');
$option = \PhpOptions\Option::directory('Foo', 'makeDir', '[BASE_PATH_OF_DIRECTORY]');
```

* **check** - check if read directory from command-line (with prefix ```[BASE_PATH_OF_DIRECTORY]```) exist.
If not, it is recursively created, **but only if final path
(read from command-line or with BASE_PATH_OF_DIRECTORY) is full path**.
* **filter** - _same as before variants_

### Email type

```php
$option = \PhpOptions\Option::email('Foo');
```

* **check** - check if email read from command-line has corect email format
* **filter** - _no filtering_

### Enum type

```php
$option = \PhpOptions\Option::enum('Foo', array('A' => 'aaa', 'B' => 'bbb', 'C' => 'ccc'));
```

* **check** - check if value read from command-line is one of set in costruct
(in example 'aaa' or 'bbb' or 'ccc').
* **filter** - return key of value
(in exmaple for 'aaa' is returned 'A', for 'bbb' is returned 'B' and for 'ccc' is returned 'C')

```php
$option = \PhpOptions\Option::enum('Foo', array('aaa', 'bbb', 'ccc'));
```

* **check** - check if value read from command-line is one of set in costruct
(in example 'aaa' or 'bbb' or 'ccc').
* **filter** - return index of value
(in exmaple for 'aaa' is returned 0, for 'bbb' is returned 1 and for 'ccc' is returned 2)

```php
$option = \PhpOptions\Option::enum('Foo', 'aaa,bbb,ccc');
```

* **check** - check if value read from command-line is one of set in costruct,
delimited by one of possible delimiters (in example 'aaa' or 'bbb' or 'ccc').
Possible delimiters are ```,```, ```;```, "_space_" or ```|```.
* **filter** - _no fltering_

### File type

```php
$option = \PhpOptions\Option::file('Foo');
```

* **check** - check if file read from command-line exist
* **filter** - return read file from command-line with corect OS directory separator

```php
$option = \PhpOptions\Option::file('Foo', '[BASE_PATH_OF_FILE]');
```

* **check** - check if read file from command-line with prefix ```[BASE_PATH_OF_FILE]``` exist
* **filter** - return read file from command-line with prefix ```[BASE_PATH_OF_FILE]```
and with corect OS directory separator

### Inifile type

```php
$option = \PhpOptions\Option::inifile('Foo');
```

* **check** - check if file read from command-line exist
* **filter** - return content of read file from command-line as array
with sections as separated values in array (```<``` is supported for inheriting of sections)

```php
$option = \PhpOptions\Option::inifile('Foo', '[BASE_PATH_OF_FILE]');
```

* **check** - check if read file from command-line with prefix ```[BASE_PATH_OF_FILE]``` exist
* **filter** - return content of read file from command-line with prefix ```[BASE_PATH_OF_FILE]``` as array
with sections as separated values in array (```<``` is supported for inheriting of sections)

```php
$option = \PhpOptions\Option::inifile('Foo', 'notSections');
```

* **check** - check if read file from command-line exist
* **filter** - return content of read file from command-line as array without sections
(all values are read as from one section)

```php
$option = \PhpOptions\Option::inifile('Foo', '[BASE_PATH_OF_FILE]', 'notSections');
```

* **check** - check if read file from command-line exist
* **filter** - return content of read file from command-line with prefix ```[BASE_PATH_OF_FILE]```
as array without sections (all values are read as from one section)

### Integer type

```php
$option = \PhpOptions\Option::integer('Foo');
```

* **check** - check value read from command-line is integer
* **filter** - return value cast as integer

```php
$option = \PhpOptions\Option::integer('Foo', 'unsigned');
```

* **check** - check value read from command-line is unsigned integer
* **filter** - _same as defautl_

### Read type

```php
$option = \PhpOptions\Option::real('Foo');
```

* **check** - check value read from command-line is real
(decimal part can be separated by ```.``` or ```,```)
* **filter** - return value cast as real

```php
$option = \PhpOptions\Option::real('Foo', 'unsigned');
```

* **check** - check value read from command-line is unsigned real
(decimal part can be separated by ```.``` or ```,```)
* **filter** - _same as defautl_

### Series (array) type

```php
$option = \PhpOptions\Option::series('Foo');
```

* **check** - _no checking_
* **filter** - return value read from command-line as array,
delimited by default delimiters ```,```, ```;```, "_space_" or ```|```.

```php
$option = \PhpOptions\Option::series('Foo', '[DELIMITERS]');
```

* **check** - _no checking_
* **filter** - return value read from command-line as array, delimited by ```[DELIOMITERS]```
(each character in string ```[DELIMITERS]``` considered as one possible delimiter)

### String type

```php
$option = \PhpOptions\Option::string('Foo');
```

* **check** - _no checking_
* **filter** - _no filtering_

### Time type

```php
$option = \PhpOptions\Option::time('Foo');
```

* **check** - value have to has format ```HOURS[(-|:)MINUTES[(-|:)SECONDS]][ HOURS_FORMAT]```

	* ```HOURS``` = one-digit or two-digit number
	* ```MINUTES``` = one-digit or two-digit number
	* ```SECONDS``` = one-digit or two-digit number
	* ```HOURS_FORMAT``` = hour format = ```(AM|am|A|a|PM|pm|P|p)```

* **filter** - return value read from command-line converted into format
```<HOURS>:<MINUTES>:<SECONDS><HOURS_FORMAT>```


Register own type
-----------------

It is possible register own new types or replace default types.
Registered type nave to by child of class ```\PhpOptions\Types\AType```.

```php
\PhpOptions\Option::registerType('fullname', '\MyNamesace\FullNameType', '/user/novak/FullNameType.php');
$option = \PhpOptions\Option::fullname('Foo');
```

In the example, new type named ```fullname``` is registered and option of this type is made.
Second parameter is name of class defined the type and
third pramater is path to file contains the class ```\MyNamesace\FullNameType```.

```php
\PhpOptions\Option::registerType('integer', '\MyNamesace\IntegerType', '/user/novak/IntegerType.php');
$option = \PhpOptions\Option::integer('Foo');
```

In the second example, own integer type is registered and default integer type is redefined.


Set one option
--------------

We can modifi setting for each option by many functions. Each function return self,
thus we can use fluent writing for seting of option.

```php
$option = \PhpOptions\Option::make('Foo')->short('x')->long('abc');
```

### Short variant option

```php
$option = \PhpOptions\Option::make('Foo');
```

Defalt short variant of option is lowercase first letter of name (in exmaple ```-f``` in command-line)

```php
$option = \PhpOptions\Option::make('Foo')->short('x');
```

Set short variant of option on ```-x```.

### Long variant of option

```php
$option = \PhpOptions\Option::make('Foo   bar');
```

Defalt long variant of option is lowercase of name with one dash intead of each series of no-letters character
(in exmaple ```--foo-bar``` in command-line).

```php
$option = \PhpOptions\Option::make('Foo')->long('xyz');
```

Set long variant of option on ```--xyz```.

### Required option

Option is not required as default.

```php
$option = \PhpOptions\Option::make('Foo')->required();
```

Set option as required. It does not make sense for option with default value and required value.

### Expected value of option

Option has not expected any value as default.

```php
$option = \PhpOptions\Option::make('Foo')->value();
```

Set option with required value.

```php
$option = \PhpOptions\Option::make('Foo')->value(FALSE);
```

Set option with optional value.

### Default value of option

```php
$option = \PhpOptions\Option::make('Foo')->value(FALSE)->defaults('Lorem ipsum');
```

It make sence only for option with optional value or optional option with optional or required value. If option is not set on command-line or
is set without value on command-line, default value is returned (see **Get value of defined options read from command-line**).
The example set default value of option on 'Lorem ipsum'.

### Description of option

Option has empty description as default.

```php
$option = \PhpOptions\Option::make('Foo')->description('Lorem ipsum');
```

Set description of option in help on 'Lorem ipsum'.



Collect all defined options together
------------------------------------

### Make object for collecting of defined options

```php
$options = new \PhpOptions\Options();
```

### Add options

We can add options together (in array) or separately.

```php
$foo = \PhpOptions\Option::make('Foo');
$bar = \PhpOptions\Option::make('Bar');
$car = \PhpOptions\Option::make('Car');
$options->add(array($foo, $bar));
$options->add($car);
```


Set collected options
---------------------

```php
$options = new \PhpOptions\Options();
$foo = \PhpOptions\Option::make('Foo');
$bar = \PhpOptions\Option::make('Bar');
$car = \PhpOptions\Option::make('Car');
$options->add(array($foo, $bar, $car));
```


### Defult option

```php
$options->defaults('Foo');
```

If any option is not defined on command-line, this option is cosidered as set.

### Description of all options together

```php
$options->decription('Lorem ipsum');
```

It set description of script showed in generated help.

### Group of options

```php
$options->group('[NAME_OF_GROUP]', array('Foo', 'Bar'));
```

It set group of options showed in generated help with name ```[NAME_OF_GROUP]```.

### Dependences of options

```php
$options->dependences('Foo', array('Bar'));
```

It define, that option ```Foo``` need option ```Bar```. If option ```Foo``` is set in command-lien,
it have to be set option ```Bar``` in comman-line too or option ```Bar``` have to have default value.

```php
$options->dependences('Foo', array('Bar'), '[NAME_OF_GROUP]');
```

It define dependences same as first example and moreover make froup from options 'Foo' and 'Bar'.


Generate help
-------------
```php
$optionsList = array();

// make list of options

$options = new \PhpOptions\Options();
$options->add($optionsList);
$options->decription('Lorem ipsum');

// define groups and dependences

echo $options->getHelp();
```

It print help for all defined options with descriptions.
Grouped options are showen separately.
For each option description, type, requirements, value requirements are showen if they are set.



Get value of defined options read from command-line
---------------------------------------------------

```php
$fooValue = $options->get('Foo');
```

For getting value of option set in comman-line, use function ```->get([OPTION])```.
```[OPTION]``` can be:

* Name of option
* Short variant of option with ```-``` as prefix
* Long variant of option with ```--``` as prefix

```php
// definition of options
$foo = \PhpOptions\Option::make('Foo');
$bar = \PhpOptions\Option::make('Bar')->value();
$car = \PhpOptions\Option::make('Car');
$options->add(array($foo, $bar $car));

$fooValue = $options->get('Foo');
$barValue = $options->get('-b');
$carValue = $options->get('--car');
```

```php
// command line usage
my_script.php -f -b "Lorem ipsum"
```

* ```$fooValue``` is set on ```TRUE```
* ```$barValue``` is set on ```Lorem ipsum```
* ```$carValue``` is set on ```FALSE```


Exceptions
----------

```php
\PhpOptions\InvalidArgumentException
```

Exceptions made by programmer by wrong calling method (in correct scrit shoul not occured)

```php
\PhpOptions\LogicException
```

Exceptions made by programmer by wrong set of expected options together (in correct scrit shoul not occured)

```php
\PhpOptions\UserBadCallException
```

Exceptions made by user wrong using of script. This is enough to catch the exception only of the Options object.


Examples
--------

```php
require_once 'PhpOptions/PhpOptions.min.php';

use PhpOptions\Options;
use PhpOptions\Option;

$optionsList = array();
$optionsList[] = Option::make('Help')->description('Show this help');
$optionsList[] = Option::make('Name')->description('Name of user')->value();
$optionsList[] = Option::make('Home')->short()->long('home-dir')->value(FALSE)->def('./home/common')
	->description('Home directory of user');
$optionsList[] = Option::make('Favorite color')->description('User`s favorite color')->value();
$optionsList[] = Option::make('Color of eye')->description('User`s color of eye')->value();

try {
	$options = new Options();
	$options->add($optionsList);
	$options->def('Help');
	$options->description("Simple script demonstrating PhpOptions\nauthor: Viktor Masicek <viktor@masicek.net>");
} catch (\PhpOptions\UserBadCallException $e) {
	// Wrong using in command-line by user
	echo $e->getMessage();
}

// print help
if ($options->get('Help')) {
	echo $options->getHelp();
	return;
}

// get values
$name = $options->get('Name');
$home = $options->get('Home');
$favorite = $options->get('-f');
$eye = $options->get('--color-of-eye');

// print values
printf('Name: %s\n', ($name ?: ''));
printf('Home: %s\n', ($home ?: ''));
printf('Favorite color: %s\n', ($favorite ?: ''));
printf('Color of eye: %s\n', ($eye ?: ''));
```
