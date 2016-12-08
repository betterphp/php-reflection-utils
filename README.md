# PHP Reflection Utils
A small helper class to make accessing private properties and methods easier, largely used in testing.

[![Build Status](https://ci.jacekk.co.uk/buildStatus/icon?job=PHP Reflection Utils)](https://ci.jacekk.co.uk/job/PHP Reflection Utils)

## Installation
The library can be included via composer by adding a custom repo and the project name
~~~json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/betterphp/php-reflection-utils.git"
        }
    ],
    "require-dev": {
        "betterphp/php-reflection-utils": "dev-master"
    }
}
~~~
This will pull from the master branch whenever you run `composer update`, proper versioning is on the to-do list.

## Testing
We use phpcs and phpunit for testing, run both before commiting anything
~~~
./vendor/bin/phpcs -p --standard=./ruleset.xml .
~~~
~~~
./vendor/bin/phpunit -c ./phpunit.xml
~~~

phpunit will do code coverage checking which requires xdebug, if it's not installed this will fail gracefully - not to worry.

A report of the test coverage is published [here by Jenkins](https://ci.jacekk.co.uk/job/PHP Reflection Utils/HTML_Code_Coverage/index.html)