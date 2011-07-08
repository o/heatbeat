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

    public function assertPreConditions() {
        $this->assertEmpty(iterator_to_array($this->object));
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSetGetValue($index, $newval) {
        $this->object->setValue($index, $newval);
        $this->assertArrayHasKey($index, iterator_to_array($this->object));
        $this->assertEquals($this->object->getValue($index), $newval);
    }

    public function dataProvider() {
        return array(
            array('foo', 'bar'),
            array(1, 2),
            array('go', 'to'),
            array('speed', true),
            array('moo', 'foo')
        );
    }

}

?>
