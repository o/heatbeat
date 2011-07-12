<?php

namespace Heatbeat\Source;

/**
 * Test class for AbstractInputOutput.
 */
class AbstractInputOutputTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var AbstractInputOutput
     */
    protected $object;

    protected function setUp() {
        $this->object = $this->getMockForAbstractClass('Heatbeat\Source\AbstractInputOutput');
    }

    public function testGetValue() {
        $this->assertFalse($this->object->offsetExists('users'));
        $this->object->setValue('users', 5);
        $this->assertEquals(5, $this->object->getValue('users'));
    }

    public function testSetValue() {
        $this->assertFalse($this->object->offsetExists('bar'));
        $this->object->setValue('bar', 'baz');
        $this->assertEquals('baz', $this->object->getValue('bar'));
    }

}

?>
