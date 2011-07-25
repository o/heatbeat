<?php

namespace Heatbeat\Parser\Config\Node;

/**
 * Test class for GraphNode.
 */
class GraphNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($input) {
        $object = new GraphNode($input);
        $this->assertTrue($object->validate());
    }

    /**
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($input) {
        $this->setExpectedException('Heatbeat\Exception\NodeValidationException');
        $object = new GraphNode($input);
        $object->validate();
    }

    public function testGetRRDFilename() {
        $object = new GraphNode(array('template' => 'foo', 'enabled' => true));
        $this->assertStringStartsWith('foo_', $object->getRRDFilename());
        $this->assertTrue(strlen($object->getRRDFilename()) == 12);

        $object = new GraphNode(array('template' => 'buzz', 'enabled' => false, 'arguments' => array('host' => 'localhost')));
        $this->assertStringStartsWith('buzz_', $object->getRRDFilename());
        $this->assertTrue(strlen($object->getRRDFilename()) == 13);

        /**
         * For preventing changing graph node structure for future releases
         */
        $object = new GraphNode(array('template' => 'bar', 'enabled' => false, 'arguments' => array('host' => 'localhost')));
        $this->assertStringStartsWith('bar_', $object->getRRDFilename());
        $this->assertEquals('bar_1320ddb2', $object->getRRDFilename());
        }

    public function validDataProvider() {
        return array(
            array(array('template' => 'foo', 'enabled' => true)),
            array(array('template' => 'baz', 'enabled' => false)),
            array(array('template' => 'bar', 'enabled' => true, 'arguments' => array('foo' => 'bar')))
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('template' => '', 'enabled' => true)),
            array(array('template' => 'bar', 'enabled' => null)),
            array(array('templates' => 'goo', 'enabled' => true)),
            array(array('template' => 'baz', 'disabled' => true))
        );
    }

}

?>
