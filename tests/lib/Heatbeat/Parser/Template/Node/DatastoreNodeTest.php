<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for DatastoreNode.
 */
class DatastoreNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider dsDataProvider
     */
    public function testGetAsString($name, $type, $heartbeat, $min, $max, $result) {
        $object = new DatastoreNode(array(
                    'name' => $name,
                    'type' => $type,
                    'heartbeat' => $heartbeat,
                    'min' => $min,
                    'max' => $max
                ));
        $this->assertEquals($result, $object->getAsString());
    }

    public function dsDataProvider() {
        return array(
            array('temp', 'GAUGE', 600, 0, 100, 'DS:temp:GAUGE:600:0:100'),
            array('ifOutOctets', 'COUNTER', 1800, 0, 4294967295, 'DS:ifOutOctets:COUNTER:1800:0:4294967295')
        );
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate1() {
        $object = new DatastoreNode(array(
                    'type' => 'GAUGE',
                    'heartbeat' => 1200,
                    'min' => 0,
                    'max' => 'baz'
                ));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate2() {
        $object = new DatastoreNode(array(
                    'name' => 'test',
                    'type' => 'FOO',
                    'heartbeat' => 1200,
                    'min' => 0,
                    'max' => 10
                ));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate3() {
        $object = new DatastoreNode(array(
                    'name' => 'test',
                    'type' => 'GAUGE',
                    'heartbeat' => 'bar',
                    'min' => 0,
                    'max' => 10
                ));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate4() {
        $object = new DatastoreNode(array(
                    'name' => 'test',
                    'type' => 'GAUGE',
                    'heartbeat' => 1200,
                    'min' => 'bar',
                    'max' => 10
                ));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate5() {
        $object = new DatastoreNode(array(
                    'name' => 'test',
                    'type' => 'GAUGE',
                    'heartbeat' => 1200,
                    'min' => 0,
                    'max' => 'baz'
                ));
        $object->validate();
    }

}

?>
