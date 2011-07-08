<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for DatastoreNode.
 */
class DatastoreNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testGetAsString($array, $result) {
        $object = new DatastoreNode($array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('heartbeat', $array);
        $this->assertArrayHasKey('min', $array);
        $this->assertArrayHasKey('max', $array);
        $this->assertEquals($result, $object->getAsString());
        $this->assertInternalType('string', $object->getAsString());
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($array) {
        $object = new DatastoreNode($array);
        $this->assertInternalType('array', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('type', $array);
        $this->assertArrayHasKey('heartbeat', $array);
        $this->assertArrayHasKey('min', $array);
        $this->assertArrayHasKey('max', $array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($array) {
        $object = new DatastoreNode($array);
        $this->assertInternalType('array', $array);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('name' => 'ccc', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 1), 'DS:ccc:GAUGE:600:0:1'),
            array(array('name' => 'ifOutOctets', 'type' => 'COUNTER', 'heartbeat' => 1200, 'min' => 10, 'max' => 100), 'DS:ifOutOctets:COUNTER:1200:10:100'),
            array(array('name' => 'foo', 'type' => 'DERIVE', 'heartbeat' => 30, 'min' => 100, 'max' => 1000), 'DS:foo:DERIVE:30:100:1000'),
            array(array('name' => 'bar', 'type' => 'ABSOLUTE', 'heartbeat' => 600, 'min' => 0, 'max' => 100000), 'DS:bar:ABSOLUTE:600:0:100000'),
            array(array('name' => 'baz', 'type' => 'GAUGE', 'heartbeat' => 60, 'min' => 50, 'max' => 80), 'DS:baz:GAUGE:60:50:80'),
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('name' => 'ccc', 'type' => 'FOO', 'heartbeat' => 600, 'min' => 0, 'max' => 1)),
            array(array('name' => 'fuu', 'type' => 'BAR', 'heartbeat' => 1200, 'min' => 10, 'max' => 100)),
            array(array('name' => 'foo', 'type' => 'BAZ', 'heartbeat' => 30, 'min' => 100, 'max' => 1000)),
            array(array('name' => 'bar', 'type' => 'MOO', 'heartbeat' => 600, 'min' => 0, 'max' => 100000)),
            array(array('nam' => 'baz', 'type' => 'GAUGE', 'heartbeat' => 60, 'min' => 50, 'max' => 80)),
            array(array('name' => 'cc', 'typ' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 1)),
            array(array('name' => 'foo', 'type' => 'DERIVE', 'heartbea' => 30, 'min' => 100, 'max' => 1000)),
            array(array('name' => 'bar', 'type' => 'ABSOLUTE', 'heartbeat' => 600, 'mi' => 0, 'max' => 100000)),
            array(array('name' => 'baz', 'type' => 'GAUGE', 'heartbeat' => 60, 'min' => 50, 'ma' => 80)),
            array(array('name' => 'foo', 'type' => 'DERIVE', 'heartbeat' => 30, 'min' => 100, 'max' => 'baz'), 'DS:foo:DERIVE:30:100:1000'),
            array(array('name' => 'bar', 'type' => 'ABSOLUTE', 'heartbeat' => 600, 'min' => 'foo', 'max' => 100000), 'DS:bar:ABSOLUTE:600:0:100000'),
            array(array('name' => 'baz', 'type' => 'GAUGE', 'heartbeat' => 'fuu', 'min' => 50, 'max' => 80), 'DS:baz:GAUGE:60:50:80'),
            array(array('name' => 'baz!', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 50, 'max' => 80), 'DS:baz:GAUGE:60:50:80'),
            array(array('name' => '', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 50, 'max' => 80), 'DS:baz:GAUGE:60:50:80'),
            array(array('name' => '1dsa', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 50), 'DS:baz:GAUGE:60:50:80')
        );
    }

}

?>
