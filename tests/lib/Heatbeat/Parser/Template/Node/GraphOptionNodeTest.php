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
            array(array('name' => 'Tons of foos', 'label' => 'Foo values of foo', 'base' => 950, 'lower' => 0, 'upper' => 650))
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('nam' => 'Loads', 'label' => 'Test', 'base' => 1000, 'lower' => 100, 'upper' => 'auto')),
            array(array('name' => 'Disk Usage', 'labe' => 'Second Test', 'base' => 1024, 'lower' => 100, 'upper' => 350)),
            array(array('name' => 'Total of X', 'label' => 'Labelz', 'bas' => 1000, 'lower' => 'auto', 'upper' => 250)),
            array(array('name' => 'Received Y', 'label' => 'Vertical', 'base' => 1024, 'lowe' => 0, 'upper' => 150)),
            array(array('name' => 'Tons of foos', 'label' => 'Foo values of foo', 'base' => 950, 'lower' => 0, 'uppe' => 650)),
            array(array('name' => '', 'label' => 'Test', 'base' => 1000, 'lower' => 100, 'upper' => 'auto')),
            array(array('name' => 'Disk Usage', 'label' => '', 'base' => 1024, 'lower' => 100, 'upper' => 350)),
            array(array('name' => 'Total of X', 'label' => 'Labelz', 'base' => '', 'lower' => 'auto', 'upper' => 250)),
            array(array('name' => 'Received Y', 'label' => 'Vertical', 'base' => 1024, 'lower' => '', 'upper' => 150)),
            array(array('name' => 'Tons of foos', 'label' => 'Foo values of foo', 'base' => 950, 'lower' => 0, 'upper' => '')),
            array(array('name' => 'Loads', 'label' => 'Test', 'base' => 'foo', 'lower' => 100, 'upper' => 'auto')),
            array(array('name' => 'Disk Usage', 'label' => 'Second Test', 'base' => 1024, 'lower' => 'foo', 'upper' => 350)),
            array(array('name' => 'Total of X', 'label' => 'Labelz', 'base' => 1000, 'lower' => 'auto', 'upper' => 'foo')),
            array(array('name' => 'Received Y', 'label' => 'Vertical', 'base' => 1024, 'lower' => -1, 'upper' => 150))
        );
    }

}

?>
