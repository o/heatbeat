<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for GraphOptionNode.
 */
class GraphOptionNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($array) {
        $object = new GraphOptionNode($array);
        $this->assertInternalType('array', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('label', $array);
        $this->assertArrayHasKey('base', $array);
        $this->assertArrayHasKey('upper', $array);
        $this->assertArrayHasKey('lower', $array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($array) {
        $object = new GraphOptionNode($array);
        $this->assertInternalType('array', $array);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('name' => 'Loads', 'label' => 'Test', 'base' => 1000, 'lower' => 100, 'upper' => 'auto')),
            array(array('name' => 'Disk Usage', 'label' => 'Second Test', 'base' => 1024, 'lower' => 100, 'upper' => 350)),
            array(array('name' => 'Total of X', 'label' => 'Labelz', 'base' => 1000, 'lower' => 'auto', 'upper' => 250)),
            array(array('name' => 'Received Y', 'label' => 'Vertical', 'base' => 1024, 'lower' => 0, 'upper' => 150)),
            array(array('name' => 'Tons of foos', 'label' => 'Foo values of foo', 'base' => 950, 'lower' => 0, 'upper' => 650)),
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('names' => 'Loads', 'label' => 'Test', 'base' => 1000, 'lower' => 100, 'upper' => 1000)),
            array(array('name' => 'Loads', 'label' => '', 'base' => 1000, 'lower' => 100, 'upper' => 273)),
            array(array('name' => 'Loads', 'label' => 'Test', 'base' => 'auto', 'lower' => 100, 'upper' => 'auto')),
            array(array('name' => '', 'label' => 'Test', 'base' => 1000, 'lower' => 100, 'upper' => 'auto')),
            array(array('name' => '', 'label' => 'Test', 'base' => 1000, 'lower' => 100, 'upper' => -5)),
        );
    }

}

?>
