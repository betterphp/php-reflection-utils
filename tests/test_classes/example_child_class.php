<?php

declare(strict_types=1);

class example_child_class extends example_class {

    private $example_child_string_property;

    public function __construct() {
        $this->example_child_string_property = uniqid();

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function get_value($property_name) {
        if (!isset($this->{$property_name})) {
            return parent::get_value($property_name);
        } else {
            return $this->{$property_name};
        }
    }

    private function example_child_method(int $number) {
        return ($number * 20);
    }

    private static function example_child_static_method(int $number) {
        return ($number * 20);
    }

}
