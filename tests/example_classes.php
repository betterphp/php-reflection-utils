<?php

declare(strict_types=1);

class example_class {

    protected $example_string_property;
    protected $example_array_property;

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

}

class example_child_class extends example_class {

    protected $example_child_string_property;

    public function __construct() {
        $this->example_child_string_property = uniqid();

        parent::__construct();
    }

}
