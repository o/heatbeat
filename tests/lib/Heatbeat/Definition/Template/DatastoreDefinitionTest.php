<?php

namespace Heatbeat\Definition\Template;

/**
 * Test class for DatastoreDefinition.
 */
class DatastoreDefinitionTest extends \PHPUnit_Framework_TestCase {

    public function testCurrent() {
        $object = new DatastoreDefinition(array(
                    array('name' => 'foo', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 1)
                ));
        foreach ($object as $value) {
            $this->assertInstanceOf('\Heatbeat\Parser\Template\Node\DatastoreNode', $value);
        }
        $this->assertEquals(1, $object->key());
    }

    public function testCurrentWithMultipleNode() {
        $object = new DatastoreDefinition(array(
                    array('name' => 'foo', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 1),
                    array('name' => 'bar', 'type' => 'COUNTER', 'heartbeat' => 1200, 'min' => 0, 'max' => 500)
            ));
        foreach ($object as $value) {
            $this->assertInstanceOf('\Heatbeat\Parser\Template\Node\DatastoreNode', $value);
        }
        $this->assertEquals(2, $object->key());
    }
    
    
}

?>
