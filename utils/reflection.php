<?php

declare(strict_types=1);

namespace betterphp\utils;

class reflection {

    /**
     * Gets the value of an object property
     *
     * @param object $object The object to get the value from
     * @param string $property_name The name of the property
     *
     * @return mixed The value
     */
    public static function get_property($object, string $property_name) {
        $property = new \ReflectionProperty(get_class($object), $property_name);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

}
