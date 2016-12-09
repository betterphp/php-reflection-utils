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
    private $example_child_object;

    public function setUp() {
        $this->example_object = new example_class();
        $this->example_child_object = new example_child_class();
    }

    public function tearDown() {
        unset($this->example_object);
        unset($this->example_child_object);
    }

    /**
     * @dataProvider dataGetProperty
     */
    public function testGetProperty(string $property_name, string $expected_type) {
        $reflected_value = reflection::get_property($this->example_object, $property_name);
        $actual_value = $this->example_object->get_value($property_name);

        $this->assertInternalType($expected_type, $reflected_value);
        $this->assertSame($actual_value, $reflected_value);
    }

    public function dataGetProperty(): array {
        return [
            ['example_string_property', 'string'],
            ['example_array_property', 'array'],
        ];
    }

    /**
     * @dataProvider dataGetPropertyFromChild
     */
    public function testGetPropertyFromChild(string $property_name, string $expected_type) {
        $reflected_value = reflection::get_property($this->example_child_object, $property_name);
        $actual_value = $this->example_child_object->get_value($property_name);

        $this->assertInternalType($expected_type, $reflected_value);
        $this->assertSame($actual_value, $reflected_value);
    }

    public function dataGetPropertyFromChild(): array {
        return array_merge(
            $this->dataGetProperty(),
            [
                ['example_child_string_property', 'string'],
            ]
        );
    }

    public function testSetProperty() {
        $expected_value = 'wow such value';
        $property_name = 'example_string_property';

        reflection::set_property($this->example_object, $property_name, $expected_value);

        $this->assertSame($expected_value, $this->example_object->get_value($property_name));
    }

}
