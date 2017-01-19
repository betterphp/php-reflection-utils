<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use betterphp\utils\reflection;

include_once __DIR__ . '/../test_classes/example_class.php';
include_once __DIR__ . '/../test_classes/example_child_class.php';

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
     * @dataProvider dataResolvePropertyClass
     */
    public function testResolvePropertyClass(
        string $expected_class_name,
        string $input_class_name,
        string $input_property_name
    ) {
        $function = new \ReflectionMethod(reflection::class, 'resolve_property_class');
        $function->setAccessible(true);

        $actual_class_name = $function->invokeArgs(null, [&$input_class_name, &$input_property_name]);

        $this->assertSame($expected_class_name, $actual_class_name);
    }

    public function dataResolvePropertyClass(): array {
        return [
            // should return the parent regardless of the input
            [example_class::class, example_class::class, 'example_string_property'],
            [example_class::class, example_child_class::class, 'example_string_property'],
            // should return the child for it's property
            [example_child_class::class, example_child_class::class, 'example_child_string_property'],
        ];
    }

    /**
     * @dataProvider dataResolveMethodClass
     */
    public function testResolveMethodClass(
        string $expected_class_name,
        string $input_class_name,
        string $input_method_name
    ) {
        $function = new \ReflectionMethod(reflection::class, 'resolve_method_class');
        $function->setAccessible(true);

        $actual_class_name = $function->invokeArgs(null, [&$input_class_name, &$input_method_name]);

        $this->assertSame($expected_class_name, $actual_class_name);
    }

    public function dataResolveMethodClass(): array {
        return [
            // the same for methods
            [example_class::class, example_class::class, 'example_method'],
            [example_class::class, example_child_class::class, 'example_method'],
            [example_child_class::class, example_child_class::class, 'example_child_method'],
            // and static ones
            [example_class::class, example_class::class, 'example_static_method'],
            [example_class::class, example_child_class::class, 'example_static_method'],
            [example_child_class::class, example_child_class::class, 'example_child_static_method'],
        ];
    }

    public function testResolveClassWithBadProperty() {
        $property_name = 'this_is_not_a_valid_property_name';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Unable to find class for {$property_name}");

        $function = new \ReflectionMethod(reflection::class, 'resolve_property_class');
        $function->setAccessible(true);
        $function->invokeArgs(null, [example_child_class::class, $property_name]);
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
            // Same values as the parent and then the one for the child
            $this->dataGetProperty(),
            [
                ['example_child_string_property', 'string'],
            ]
        );
    }

    public function testGetStaticProperty() {
        $property_name = 'example_static_property';
        $reflected_value = reflection::get_property(example_class::class, $property_name);
        $actual_value = example_class::get_static_value($property_name);

        $this->assertInternalType('string', $reflected_value);
        $this->assertSame($actual_value, $reflected_value);
    }

    public function testGetChildStaticProperty() {
        $property_name = 'example_child_static_property';
        $reflected_value = reflection::get_property(example_child_class::class, $property_name);
        $actual_value = example_child_class::get_static_value($property_name);

        $this->assertInternalType('string', $reflected_value);
        $this->assertSame($actual_value, $reflected_value);
    }

    public function testSetProperty() {
        $expected_value = 'wow such value';
        $property_name = 'example_string_property';

        reflection::set_property($this->example_object, $property_name, $expected_value);

        $this->assertSame($expected_value, $this->example_object->get_value($property_name));
    }

    public function testSetStaticProperty() {
        $property_name = 'example_static_property';
        $expected_value = uniqid();

        $starting_value = example_class::get_static_value($property_name);
        reflection::set_property(example_class::class, $property_name, $expected_value);
        $new_value = example_class::get_static_value($property_name);

        $this->assertNotSame($starting_value, $new_value);
        $this->assertSame($expected_value, $new_value);
    }

    // These have to be seperate as data providers don't have access to things defined in setUp()

    /**
     * @dataProvider dataCallMethod
     */
    public function testCallMethod(string $object_property, string $method_name, int $input, int $expected) {
        $this->assertSame($expected, reflection::call_method($this->{$object_property}, $method_name, $input));
    }

    public function dataCallMethod(): array {
        return [
            ['example_object', 'example_method', 10, 100],
            ['example_child_object', 'example_child_method', 10, 200],
        ];
    }

    /**
     * @dataProvider dataCallStaticMethod
     */
    public function testCallStaticMethod(string $class_name, string $method_name, int $input, int $expected) {
        $this->assertSame($expected, reflection::call_method($class_name, $method_name, $input));
    }

    public function dataCallStaticMethod(): array {
        return [
            [example_class::class, 'example_static_method', 20, 200],
            [example_child_class::class, 'example_child_static_method', 20, 400],
        ];
    }

    public function testCallMethodWithReference() {
        $test_value = 10;
        $expected_value = ($test_value * 2);

        reflection::call_method($this->example_object, 'test_reference_method', $test_value);

        $this->assertSame($expected_value, $test_value);
    }

    public function testCallMethodSetReferenceValue() {
        $expected_value = 'wow such test';

        reflection::call_method($this->example_object, 'test_set_reference_method', $actual_value, $expected_value);

        $this->assertSame($expected_value, $actual_value);
    }

    //

}
