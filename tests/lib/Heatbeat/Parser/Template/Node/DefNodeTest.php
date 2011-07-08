<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for DefNode.
 */
class DefNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testGetAsString($array, $result) {
        $object = new DefNode($array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('filename', $array);
        $this->assertArrayHasKey('datastore-name', $array);
        $this->assertArrayHasKey('cf', $array);
        $this->assertEquals($result, $object->getAsString());
        $this->assertInternalType('string', $object->getAsString());
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($array) {
        $object = new DefNode($array);
        $this->assertInternalType('array', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('filename', $array);
        $this->assertArrayHasKey('datastore-name', $array);
        $this->assertArrayHasKey('cf', $array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($array) {
        $object = new DefNode($array);
        $this->assertInternalType('array', $array);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('name' => 'test', 'filename' => 'baz.rrd', 'datastore-name' => 'ds1', 'cf' => 'AVERAGE'), 'DEF:test=baz.rrd:ds1:AVERAGE'),
            array(array('name' => 'def1', 'filename' => 'users.rrd', 'datastore-name' => 'def2', 'cf' => 'MAX'), 'DEF:def1=users.rrd:def2:MAX'),
            array(array('name' => 'tree', 'filename' => 'usage.rrd', 'datastore-name' => 'tree', 'cf' => 'MIN'), 'DEF:tree=usage.rrd:tree:MIN'),
            array(array('name' => 'baz', 'filename' => 'files.rrd', 'datastore-name' => 'bar', 'cf' => 'LAST'), 'DEF:baz=files.rrd:bar:LAST'),
            array(array('name' => 'averages', 'filename' => 'git.rrd', 'datastore-name' => 'averages', 'cf' => 'AVERAGE'), 'DEF:averages=git.rrd:averages:AVERAGE')
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('name' => 'test', 'filename' => 'baz.rrd', 'datastore-name' => 'ds1', 'cf' => 'AVERAGES')),
            array(array('name' => 'def1', 'filename' => 'users.rrd', 'datastore-name' => 'ds2', 'cf' => 'MORE')),
            array(array('name' => 'tree', 'filename' => 'usage.rrd', 'datastore-name' => 'tree', 'cf' => 'TIME')),
            array(array('name' => 'baz', 'filename' => 'files.rrd', 'datastore-name' => 'bar', 'cf' => 'BAZ')),
            array(array('name' => 'averages', 'filename' => '', 'datastore-name' => 'averages', 'cf' => 'AVERAGE')),
            array(array('name' => 'test!', 'filename' => 'baz.rrd', 'datastore-name' => 'ds54', 'cf' => 'AVERAGE')),
            array(array('name' => 'averages', 'filename' => 'git.rrd', 'datastore-name' => '', 'cf' => 'AVERAGE')),
            array(array('' => 'averages', 'filename' => 'total.rrd', 'datastore-name' => 'ds12', 'cf' => 'AVERAGE')),
            array(array('asd' => 'averages', 'filename' => 'disk.rrd', 'cf' => 'AVERAGE'))
        );
    }

}

?>
