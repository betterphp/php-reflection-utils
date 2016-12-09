<?php

declare(strict_types=1);

namespace betterphp\utils;

class reflection {

    /**
     * Search for the class name that a property is defined in. This is useful
     * as the reflection API needs that and not the class of the actual object.
     *
     * @param string $class_name The name of the starting class
     * @param string $name The name of the thing to search for
     * @param boolean $method If the thing being serched for is a method
     *
     * @return string The name of the owner class
     */
    private static function resolve_class(string $class_name, string $name, bool $method): string {
        $exists = ($method) ? 'method_exists' : 'property_exists';

        do {
            if ($exists($class_name, $name)) {
                return $class_name;
            }

            $class_name = get_parent_class($class_name);
        } while ($class_name !== false);

        throw new \Exception("Unable to find class for {$name}");
    }

    /**
     * Gets the value of an object property
     *
     * @param object $object The object to get the value from
     * @param string $property_name The name of the property
     *
     * @return mixed The value
     */
    public static function get_property($object, string $property_name) {
        $class_name = static::resolve_class(get_class($object), $property_name, false);
        $property = new \ReflectionProperty($class_name, $property_name);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /**
     * Sets the value of an object property
     *
     * @param object $object The object to update
     * @param string $property_name The name of the property
     * @param mixed $value The new value to set
     *
     * @return void
     */
    public static function set_property($object, string $property_name, $value) {
        $class_name = static::resolve_class(get_class($object), $property_name, false);
        $property = new \ReflectionProperty($class_name, $property_name);
        $property->setAccessible(true);

        $property->setValue($object, $value);
    }

}
