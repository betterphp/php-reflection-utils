<?php

declare(strict_types=1);

class example_child_class extends example_class {

    protected $example_child_string_property;

    public function __construct() {
        $this->example_child_string_property = uniqid();

        parent::__construct();
    }

}
