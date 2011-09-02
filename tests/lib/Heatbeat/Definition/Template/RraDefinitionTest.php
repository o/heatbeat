<?php

namespace Heatbeat\Definition\Template;

/**
 * Test class for RraDefinition.
 */
class RraDefinitionTest extends \PHPUnit_Framework_TestCase {

    public function testCurrent() {
        $object = new RraDefinition(
                        array(array('cf' => 'AVERAGE', 'xff' => 0.8, 'steps' => 2, 'rows' => 68))
        );
        foreach ($object as $value) {
            $this->assertInstanceOf('\Heatbeat\Parser\Template\Node\RraNode', $value);
        }
        $this->assertEquals(1, $object->key());
    }

    public function testCurrentWithMultipleCF() {
        $object = new RraDefinition(
                        array(array('cf' => array('AVERAGE', 'LAST'), 'xff' => 0.5, 'steps' => 4, 'rows' => 100))
        );
        foreach ($object as $value) {
            $this->assertInstanceOf('\Heatbeat\Parser\Template\Node\RraNode', $value);
        }
        $this->assertEquals(3, $object->key());
    }

    public function testCurrentWithMultipleNode() {
        $object = new RraDefinition(
                        array(
                            array('cf' => 'LAST', 'xff' => 0.5, 'steps' => 6, 'rows' => 500),
                            array('cf' => array('MAX', 'AVERAGE'), 'xff' => 0.2, 'steps' => 12, 'rows' => 720)
                        )
        );
        foreach ($object as $value) {
            $this->assertInstanceOf('\Heatbeat\Parser\Template\Node\RraNode', $value);
        }
        $this->assertEquals(4, $object->key());
    }

}

?>
