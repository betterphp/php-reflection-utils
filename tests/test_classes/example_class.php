<?php

declare(strict_types=1);

class example_class {

    private static $example_static_property = 'very private, such static, wow';

    private $example_string_property;
    private $example_array_property;

    public function __construct() {
        $this->example_string_property = uniqid();
        $this->example_array_property = [ uniqid(), uniqid(), uniqid() ];
    }

    /**
     * Gets the value of a class property by name, used to compare to the
     * value returned via reflection utils
     *
     * @param string $property_name The property name
     *
     * @return mixed The value
     */
    public function get_value($property_name) {
        return $this->{$property_name};
    }

    /**
     * Similar to get_value() except this will access static properties
     *
     * @param string $property_name The name of the property
     *
     * @return mixed The property value
     */
    public static function get_static_value(string $property_name) {
        // Note the variable variable here
        return static::$$property_name;
    }

    private function example_method(int $number) {
        return ($number * 10);
    }

    private static function example_static_method(int $number) {
        return ($number * 10);
    }

    public function test_reference_method(int &$input) {
        $input *= 2;
    }

    public function test_set_reference_method(string &$target = null, string $value) {
        $target = $value;
    }

    public function test_value_method(string $value) {
        return $value;
    }

}
