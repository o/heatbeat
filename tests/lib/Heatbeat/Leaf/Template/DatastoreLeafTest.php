<?php

namespace Heatbeat\Leaf\Template;

/**
 * Test class for DatastoreLeaf.
 */
class DatastoreLeafTest extends \PHPUnit_Framework_TestCase {

    public function validDataProvider() {
        return array(
            array(array('name' => 'temperature', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => -100, 'max' => 100), 'DS:temperature:GAUGE:600:-100:100'),
            array(array('name' => 'traffic', 'type' => 'COUNTER', 'heartbeat' => 1200, 'min' => 10, 'max' => 100), 'DS:traffic:COUNTER:1200:10:100'),
            array(array('name' => 'speed', 'type' => 'DERIVE', 'heartbeat' => 30, 'min' => 100, 'max' => 1000), 'DS:speed:DERIVE:30:100:1000'),
            array(array('name' => 'humidity', 'type' => 'ABSOLUTE', 'heartbeat' => 600, 'min' => 0, 'max' => 100000), 'DS:humidity:ABSOLUTE:600:0:100000'),
            array(array('name' => 'load5min', 'type' => 'GAUGE', 'heartbeat' => 60, 'min' => 50, 'max' => 80), 'DS:load5min:GAUGE:60:50:80'),
            array(array('name' => 'beat', 'type' => 'GAUGE', 'heartbeat' => 120), 'DS:beat:GAUGE:120:U:U')
        );
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testValidateWithValidData($data) {
        $object = new DatastoreLeaf($data);
        $this->assertTrue($object->validate());
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testGetAsStringWithValidData($data, $result) {
        $object = new DatastoreLeaf($data);
        $this->assertEquals($result, $object->getAsString());
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateBlankName() {
        $object = new DatastoreLeaf(array('name' => null, 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 100));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateBlankType() {
        $object = new DatastoreLeaf(array('name' => 'foo', 'type' => null, 'heartbeat' => 600, 'min' => 0, 'max' => 100));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateBlankHeartbeat() {
        $object = new DatastoreLeaf(array('name' => 'foo', 'type' => 'GAUGE', 'heartbeat' => null, 'min' => 0, 'max' => 100));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateNonValidType() {
        $object = new DatastoreLeaf(array('name' => 'foo', 'type' => 'FIRE', 'heartbeat' => 600, 'min' => 0, 'max' => 100));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateNonValidHeartbeat() {
        $object = new DatastoreLeaf(array('name' => 'foo', 'type' => 'GAUGE', 'heartbeat' => -200, 'min' => 0, 'max' => 100));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateNonValidMin() {
        $object = new DatastoreLeaf(array('name' => 'foo', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 'baz', 'max' => 100));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateNonValidMax() {
        $object = new DatastoreLeaf(array('name' => 'foo', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 'bar'));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateWithLackingValue() {
        $object = new DatastoreLeaf(array('type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 100));
        $object->validate();
    }    
    
}