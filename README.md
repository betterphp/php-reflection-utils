# PHP Reflection Utils
A small helper class to make accessing private properties and methods easier, largely used in testing.

[![Build Status](https://ci.jacekk.co.uk/buildStatus/icon?job=PHP%20Reflection%20Utils)](https://ci.jacekk.co.uk/job/PHP%20Reflection%20Utils)

## Installation
The library can be included via composer
~~~json
{
    "require-dev": {
        "betterphp/php-reflection-utils": "1.0.0"
    }
}
~~~

## Documentation
Jenkins publishes a phpdoc [here](https://ci.jacekk.co.uk/view/Websites/job/PHP%20Reflection%20Utils/API_Docs/classes/betterphp.utils.reflection.html)

## Testing
We use phpcs and phpunit for testing, run both before commiting anything
~~~
./vendor/bin/phpcs -p --standard=./ruleset.xml .
~~~
~~~
./vendor/bin/phpunit -c ./phpunit.xml
~~~

phpunit will do code coverage checking which requires xdebug, if it's not installed this will fail gracefully - not to worry.

A report of the test coverage is published [here by Jenkins](https://ci.jacekk.co.uk/job/PHP%20Reflection%20Utils/HTML_Code_Coverage/index.html)
