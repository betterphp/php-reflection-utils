<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use betterphp\utils\reflection;

include_once __DIR__ . '/../example_classes.php';

/**
 * @covers \betterphp\utils\reflection
 */
class ReflectionTest extends TestCase {

    private $example_object;

    public function setUp() {
        $this->example_object = new example_class();
    }

    public function tearDown() {
        unset($this->example_object);
    }

    /**
     * @dataProvider dataGetProperty
     */
    public function testGetProperty(string $property_name) {
        $this->assertSame(
            $this->example_object->get_value($property_name),
            reflection::get_property($this->example_object, $property_name)
        );
    }

    public function dataGetProperty(): array {
        return [
            ['example_string_property'],
            ['example_array_property'],
        ];
    }

}
